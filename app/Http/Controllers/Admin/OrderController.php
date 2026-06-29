<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusUpdatedMail;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $status = $request->input('status');
        $search = $request->input('search');
        $query = Order::with(['user', 'items.product'])->latest();

        if ($status && $status !== 'All Statuses') {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('shipping_name', 'like', "%{$search}%")
                  ->orWhere('shipping_phone', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->paginate(15)->withQueryString();

        return view('admin.orders', compact('orders', 'status', 'search'));
    }

    /**
     * Update the status/payment status of an order.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'nullable|in:pending,processing,shipped,completed,cancelled',
            'payment_status' => 'nullable|in:pending,paid',
            'tracking_note' => 'nullable|string'
        ]);

        $statusChanged = false;
        if ($request->has('status') && $order->status !== $request->status) {
            $order->status = $request->status;
            $statusChanged = true;
        }

        if ($request->has('payment_status')) {
            $order->payment_status = $request->payment_status;
        }

        $order->save();

        // Save tracking note if provided, or if status changed (even without a note)
        if ($request->filled('tracking_note') || $statusChanged) {
            \App\Models\OrderStatusUpdate::create([
                'order_id' => $order->id,
                'status' => $order->status,
                'note' => $request->tracking_note,
            ]);
        }

        if ($statusChanged) {
            try {
                if ($order->user) {
                    Mail::to($order->user->email)->send(new OrderStatusUpdatedMail($order));
                }
            } catch (\Exception $mailEx) {
                \Illuminate\Support\Facades\Log::warning("OrderStatusUpdatedMail failed to send for order {$order->order_number}: " . $mailEx->getMessage());
            }
        }

        return back()->with('success', 'Order updated successfully.');
    }

    /**
     * Delete an order.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return back()->with('success', 'Order deleted successfully.');
    }

    /**
     * Display a deep order management dashboard.
     */
    public function deepManage(Request $request)
    {
        $status = $request->input('status', 'all');
        $month = $request->input('month', 'all');
        $search = $request->input('search');

        $query = Order::with(['user', 'items.product'])->latest();

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        if ($month && $month !== 'all') {
            $parts = explode('-', $month);
            if (count($parts) === 2) {
                $query->whereYear('created_at', $parts[0])
                      ->whereMonth('created_at', $parts[1]);
            }
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('shipping_name', 'like', "%{$search}%")
                  ->orWhere('shipping_phone', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Available Months Filter Loader
        $availableMonths = collect();
        try {
            $monthsData = Order::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month_val, DATE_FORMAT(created_at, '%M %Y') as month_name")
                ->groupBy('month_val', 'month_name')
                ->orderBy('month_val', 'desc')
                ->get();
            $availableMonths = $monthsData;
        } catch (\Exception $e) {
            $ordersForMonths = Order::select('created_at')->orderBy('created_at', 'desc')->get();
            $availableMonths = $ordersForMonths->map(function ($ord) {
                return (object)[
                    'month_val' => $ord->created_at->format('Y-m'),
                    'month_name' => $ord->created_at->format('F Y')
                ];
            })->unique('month_val')->values();
        }

        // Dynamic Statistics calculated for the selected month
        $statsQuery = Order::query();
        if ($month && $month !== 'all') {
            $parts = explode('-', $month);
            if (count($parts) === 2) {
                $statsQuery->whereYear('created_at', $parts[0])
                           ->whereMonth('created_at', $parts[1]);
            }
        }
        $statsOrders = $statsQuery->get();
        $monthOrdersCount = $statsOrders->count();
        $monthRevenue = $statsOrders->where('payment_status', 'paid')->sum('total_amount');
        $monthPendingCount = $statsOrders->where('status', 'pending')->count();
        $monthCompletedCount = $statsOrders->where('status', 'completed')->count();
        $monthCancelledCount = $statsOrders->where('status', 'cancelled')->count();

        $orders = $query->paginate(15)->withQueryString();

        return view('admin.orders-deep-manage', compact(
            'orders', 'status', 'month', 'search', 'availableMonths',
            'monthOrdersCount', 'monthRevenue', 'monthPendingCount', 'monthCompletedCount', 'monthCancelledCount'
        ));
    }

    /**
     * Export the filtered orders matching specific status & month filters.
     */
    public function export(Request $request)
    {
        $status = $request->input('status', 'all');
        $month = $request->input('month', 'all');
        $format = $request->input('format', 'excel');

        $query = Order::with(['user', 'items.product'])->latest();

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        if ($month && $month !== 'all') {
            $parts = explode('-', $month);
            if (count($parts) === 2) {
                $query->whereYear('created_at', $parts[0])
                      ->whereMonth('created_at', $parts[1]);
            }
        }

        $orders = $query->get();

        if ($format === 'excel') {
            $filename = "orders_export_" . $status . "_" . $month . "_" . date('Ymd_His') . ".csv";
            
            $headers = [
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$filename",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            ];

            $columns = ['Order Number', 'Date', 'Customer Name', 'Customer Email', 'Phone', 'Address', 'Products', 'Payment Status', 'Order Status', 'Total Amount'];

            $callback = function() use($orders, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                foreach ($orders as $order) {
                    $itemsDesc = [];
                    foreach ($order->items as $item) {
                        $itemsDesc[] = ($item->product->name ?? 'Product') . " (x" . $item->quantity . ")";
                    }
                    
                    fputcsv($file, [
                        $order->order_number,
                        $order->created_at->format('Y-m-d H:i:s'),
                        $order->shipping_name ?: ($order->user->name ?? ''),
                        $order->user->email ?? '',
                        $order->shipping_phone,
                        $order->shipping_address,
                        implode(', ', $itemsDesc),
                        $order->payment_status,
                        $order->status,
                        $order->total_amount
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        if ($format === 'word') {
            $filename = "orders_export_" . $status . "_" . $month . "_" . date('Ymd_His') . ".doc";
            
            $html = '
            <html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns="http://www.w3.org/TR/REC-html40">
            <head>
                <title>Orders Export</title>
                <style>
                    body { font-family: Arial, sans-serif; font-size: 11pt; }
                    table { border-collapse: collapse; width: 100%; margin-top: 20px; }
                    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                    th { background-color: #f2f2f2; font-weight: bold; }
                    .header { text-align: center; margin-bottom: 30px; }
                    .header h2 { margin: 0; color: #333; }
                    .status-pill { padding: 3px 8px; border-radius: 4px; font-weight: bold; font-size: 9pt; }
                    .completed { background-color: #e6f4ea; color: #137333; }
                    .pending { background-color: #fef7e0; color: #b06000; }
                    .cancelled { background-color: #fce8e6; color: #c5221f; }
                </style>
            </head>
            <body>
                <div class="header">
                    <h2>GetCare Beauty - Orders Report</h2>
                    <p>Status: ' . ucfirst($status) . ' | Month: ' . ($month === 'all' ? 'All Months' : date('F Y', strtotime($month . '-01'))) . '</p>
                    <p>Generated on: ' . date('Y-m-d H:i:s') . '</p>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Shipping Details</th>
                            <th>Products</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>';
                    
            foreach ($orders as $order) {
                $itemsHtml = '';
                foreach ($order->items as $item) {
                    $itemsHtml .= '• ' . htmlspecialchars($item->product->name ?? 'Product') . ' (x' . $item->quantity . ')<br>';
                }
                
                $statusClass = in_array($order->status, ['completed', 'pending', 'cancelled']) ? $order->status : 'pending';
                
                $html .= '
                        <tr>
                            <td><b>#' . $order->order_number . '</b></td>
                            <td>' . $order->created_at->format('Y-m-d') . '</td>
                            <td>' . htmlspecialchars($order->shipping_name) . '<br><small>' . htmlspecialchars($order->user->email ?? '') . '</small></td>
                            <td>' . htmlspecialchars($order->shipping_phone) . '<br><small>' . htmlspecialchars($order->shipping_address) . '</small></td>
                            <td>' . $itemsHtml . '</td>
                            <td>' . strtoupper($order->payment_status) . ' (' . strtoupper($order->payment_method ?? 'COD') . ')</td>
                            <td><span class="status-pill ' . $statusClass . '">' . ucfirst($order->status) . '</span></td>
                            <td><b>' . \App\Helpers\CurrencyHelper::formatForOrder($order->total_amount, $order) . '</b></td>
                        </tr>';
            }
            
            $html .= '
                    </tbody>
                </table>
            </body>
            </html>';

            return response($html, 200, [
                "Content-type"        => "application/vnd.ms-word",
                "Content-Disposition" => "attachment;Filename=$filename",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            ]);
        }

        if ($format === 'pdf') {
            return view('admin.orders-export-print', compact('orders', 'status', 'month'));
        }

        return redirect()->back()->with('error', 'Invalid export format requested.');
    }
}
