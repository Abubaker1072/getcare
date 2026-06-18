<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreSetting;
use Illuminate\Http\Request;
use App\Repositories\Contracts\PaymentGatewayRepositoryInterface;
use App\Repositories\Contracts\PaymentTransactionRepositoryInterface;

class StoreManageController extends Controller
{
    protected $gatewayRepo;
    protected $transactionRepo;

    public function __construct(
        PaymentGatewayRepositoryInterface $gatewayRepo,
        PaymentTransactionRepositoryInterface $transactionRepo
    ) {
        $this->gatewayRepo = $gatewayRepo;
        $this->transactionRepo = $transactionRepo;
    }

    public function index()
    {
        return view('admin.store-manage');
    }

    public function paymentGateways()
    {
        $gatewaySettings = $this->gatewayRepo->getAdminGatewaySettings();
        $transactions = $this->transactionRepo->getAllTransactions();
        return view('admin.payment-gateways', compact('gatewaySettings', 'transactions'));
    }

    public function update(Request $request)
    {
        $request->validate([
            // Themes and layout
            'homepage_theme' => 'nullable|in:theme_1,theme_2',
            'homepage_layout' => 'nullable|string',

            // Articles content
            'article_1_title' => 'nullable|string|max:255',
            'article_1_text' => 'nullable|string',
            'article_1_link' => 'nullable|string|max:2000',
            'article_1_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',

            'article_2_title' => 'nullable|string|max:255',
            'article_2_text' => 'nullable|string',
            'article_2_link' => 'nullable|string|max:2000',
            'article_2_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',

            'article_3_title' => 'nullable|string|max:255',
            'article_3_text' => 'nullable|string',
            'article_3_link' => 'nullable|string|max:2000',
            'article_3_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',

            // Complete routine images
            'routine_product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'routine_lifestyle_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',

            // Company details
            'company_name' => 'nullable|string|max:255',
            'support_phone' => 'nullable|string|max:50',
            'support_email' => 'nullable|email|max:255',
            'street_address' => 'nullable|string',
            'city' => 'nullable|string|max:200',
            'state' => 'nullable|string|max:200',
            'zip_code' => 'nullable|string|max:50',
            
            // Hero section config
            'hero_title' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string|max:255',
            'hero_media_type' => 'sometimes|required|in:image,video',
            'hero_media' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,mp4,webm,ogg|max:20480', // Max 20MB for video
            
            // Scheduled hero section slider
            'hero_active_mode' => 'nullable|in:default,slider',
            'hero_slider_interval' => 'nullable|integer|min:5',
            'hero_sch_image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'hero_sch_image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'hero_sch_image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'hero_sch_video_1' => 'nullable|mimetypes:video/mp4,video/webm,video/ogg|max:20480',
            'hero_sch_video_2' => 'nullable|mimetypes:video/mp4,video/webm,video/ogg|max:20480',
            
            // Countdown Timer
            'countdown_is_active' => 'nullable|in:0,1',
            'countdown_end_time' => 'nullable|date',
            'countdown_text' => 'nullable|string|max:255',

            // Shipping & Payments
            'shipping_fee' => 'nullable|numeric|min:0',
            'shipping_is_active' => 'nullable|in:0,1',
            'cod_is_active' => 'nullable|in:0,1',
            'cod_description' => 'nullable|string',
            'bank_is_active' => 'nullable|in:0,1',
            'bank_details' => 'nullable|string',

            // Admin Payment Gateway credentials
            'admin_bank_name' => 'nullable|string|max:255',
            'admin_account_number' => 'nullable|string|max:255',
            'admin_account_holder_name' => 'nullable|string|max:255',
            'admin_cvc' => 'nullable|string|max:4',
            'admin_expiry_date' => 'nullable|string|max:10',

            // Why Choose Us fields
            'why_choose_us_subtitle' => 'nullable|string|max:255',
            'why_choose_us_title' => 'nullable|string|max:255',
            'why_choose_us_card1_title' => 'nullable|string|max:255',
            'why_choose_us_card1_desc' => 'nullable|string',
            'why_choose_us_card2_title' => 'nullable|string|max:255',
            'why_choose_us_card2_desc' => 'nullable|string',
            'why_choose_us_card3_title' => 'nullable|string|max:255',
            'why_choose_us_card3_desc' => 'nullable|string',
            'why_choose_us_card1_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'why_choose_us_card2_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'why_choose_us_card3_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ]);

        // Simple text fields saving
        $keys = [
            'company_name', 'support_phone', 'support_email', 'street_address', 'city', 'state', 'zip_code',
            'hero_title', 'hero_subtitle', 'hero_media_type', 'hero_active_mode',
            'hero_slider_interval',
            'countdown_is_active', 'countdown_end_time', 'countdown_text',
            'shipping_fee', 'shipping_is_active', 'cod_is_active', 'cod_description', 'bank_is_active', 'bank_details',
            'homepage_theme', 'homepage_layout',
            'article_1_title', 'article_1_text', 'article_1_link',
            'article_2_title', 'article_2_text', 'article_2_link',
            'article_3_title', 'article_3_text', 'article_3_link',
            'why_choose_us_subtitle', 'why_choose_us_title',
            'why_choose_us_card1_title', 'why_choose_us_card1_desc',
            'why_choose_us_card2_title', 'why_choose_us_card2_desc',
            'why_choose_us_card3_title', 'why_choose_us_card3_desc'
        ];

        foreach ($keys as $key) {
            if ($request->has($key)) {
                StoreSetting::setValue($key, $request->input($key));
            }
        }

        // Default Hero Background media upload
        if ($request->hasFile('hero_media')) {
            $file = $request->file('hero_media');
            $fileName = 'hero_background_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('hero', $fileName, 'public');
            StoreSetting::setValue('hero_media_path', $path);
        }

        // Scheduled Hero Background Slider media upload (to DB)
        $uploadSlots = [
            'hero_sch_image_1' => ['order' => 1, 'type' => 'image'],
            'hero_sch_image_2' => ['order' => 2, 'type' => 'image'],
            'hero_sch_image_3' => ['order' => 3, 'type' => 'image'],
            'hero_sch_video_1' => ['order' => 4, 'type' => 'video'],
            'hero_sch_video_2' => ['order' => 5, 'type' => 'video'],
        ];

        foreach ($uploadSlots as $inputName => $slot) {
            if ($request->hasFile($inputName)) {
                $file = $request->file($inputName);
                $fileName = 'hero_slider_' . $slot['order'] . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('hero', $fileName, 'public');
                
                \App\Models\HeroSlider::updateOrCreate(
                    ['sort_order' => $slot['order']],
                    ['type' => $slot['type'], 'media_path' => $path]
                );
            }
        }

        // Article 1 Image Upload
        if ($request->hasFile('article_1_image')) {
            $file = $request->file('article_1_image');
            $fileName = 'article_1_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('articles', $fileName, 'public');
            StoreSetting::setValue('article_1_image_path', $path);
        }

        // Article 2 Image Upload
        if ($request->hasFile('article_2_image')) {
            $file = $request->file('article_2_image');
            $fileName = 'article_2_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('articles', $fileName, 'public');
            StoreSetting::setValue('article_2_image_path', $path);
        }

        // Article 3 Image Upload
        if ($request->hasFile('article_3_image')) {
            $file = $request->file('article_3_image');
            $fileName = 'article_3_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('articles', $fileName, 'public');
            StoreSetting::setValue('article_3_image_path', $path);
        }

        // Routine Product Image Upload
        if ($request->hasFile('routine_product_image')) {
            $file = $request->file('routine_product_image');
            $fileName = 'routine_product_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('routine', $fileName, 'public');
            StoreSetting::setValue('routine_product_image_path', $path);
        }

        // Routine Lifestyle Image Upload
        if ($request->hasFile('routine_lifestyle_image')) {
            $file = $request->file('routine_lifestyle_image');
            $fileName = 'routine_lifestyle_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('routine', $fileName, 'public');
            StoreSetting::setValue('routine_lifestyle_image_path', $path);
        }

        // Why Choose Us Images Deletion
        if ($request->input('delete_why_choose_us_card1_image') == '1') {
            StoreSetting::setValue('why_choose_us_card1_image_path', null);
        }
        if ($request->input('delete_why_choose_us_card2_image') == '1') {
            StoreSetting::setValue('why_choose_us_card2_image_path', null);
        }
        if ($request->input('delete_why_choose_us_card3_image') == '1') {
            StoreSetting::setValue('why_choose_us_card3_image_path', null);
        }

        // Why Choose Us Images Upload
        if ($request->hasFile('why_choose_us_card1_image')) {
            $file = $request->file('why_choose_us_card1_image');
            $fileName = 'why_choose_us_card1_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('why_choose_us', $fileName, 'public');
            StoreSetting::setValue('why_choose_us_card1_image_path', $path);
        }
        if ($request->hasFile('why_choose_us_card2_image')) {
            $file = $request->file('why_choose_us_card2_image');
            $fileName = 'why_choose_us_card2_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('why_choose_us', $fileName, 'public');
            StoreSetting::setValue('why_choose_us_card2_image_path', $path);
        }
        if ($request->hasFile('why_choose_us_card3_image')) {
            $file = $request->file('why_choose_us_card3_image');
            $fileName = 'why_choose_us_card3_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('why_choose_us', $fileName, 'public');
            StoreSetting::setValue('why_choose_us_card3_image_path', $path);
        }

        // Save Admin Gateway bank settings if present
        if ($request->has('admin_bank_name') || $request->has('admin_account_number')) {
            $this->gatewayRepo->saveAdminGatewaySettings([
                'admin_bank_name' => $request->input('admin_bank_name'),
                'admin_account_number' => $request->input('admin_account_number'),
                'admin_account_holder_name' => $request->input('admin_account_holder_name'),
                'admin_cvc' => $request->input('admin_cvc'),
                'admin_expiry_date' => $request->input('admin_expiry_date'),
            ]);
        }

        return redirect()->back()->with('success', 'Store settings updated successfully.');
    }

    public function reset()
    {
        $keys = [
            'hero_title', 'hero_subtitle', 'hero_media_type', 'hero_media_path',
            'hero_active_mode', 'hero_slider_interval',
            'countdown_is_active', 'countdown_end_time', 'countdown_text',
            'homepage_theme', 'homepage_layout',
            'article_1_title', 'article_1_text', 'article_1_link', 'article_1_image_path',
            'article_2_title', 'article_2_text', 'article_2_link', 'article_2_image_path',
            'article_3_title', 'article_3_text', 'article_3_link', 'article_3_image_path',
            'routine_product_image_path', 'routine_lifestyle_image_path',
            'why_choose_us_subtitle', 'why_choose_us_title',
            'why_choose_us_card1_title', 'why_choose_us_card1_desc', 'why_choose_us_card1_image_path',
            'why_choose_us_card2_title', 'why_choose_us_card2_desc', 'why_choose_us_card2_image_path',
            'why_choose_us_card3_title', 'why_choose_us_card3_desc', 'why_choose_us_card3_image_path'
        ];

        foreach ($keys as $key) {
            StoreSetting::where('key', $key)->delete();
        }

        return redirect()->back()->with('success', 'Store customizations reset to default values successfully.');
    }

    /**
     * Download processed bank payments as a CSV spreadsheet.
     */
    public function downloadTransactions()
    {
        $transactions = $this->transactionRepo->getAllTransactions();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=processed_payments_" . date('Y-m-d') . ".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($transactions) {
            $file = fopen('php://output', 'w');
            
            // Add column headers
            fputcsv($file, [
                'Order ID / Number', 
                'Customer User Name', 
                'Customer User Email', 
                'Customer Bank Name', 
                'Customer Account/IBAN Number', 
                'Account Title/Holder Name', 
                'CVC', 
                'Expiry Date', 
                'Amount', 
                'Status', 
                'Transaction Date'
            ]);

            foreach ($transactions as $txn) {
                fputcsv($file, [
                    $txn->order ? $txn->order->order_number : 'N/A',
                    $txn->order && $txn->order->user ? $txn->order->user->name : 'Guest/Deleted User',
                    $txn->order && $txn->order->user ? $txn->order->user->email : 'N/A',
                    $txn->customer_bank_name,
                    $txn->customer_account_number,
                    $txn->customer_account_holder_name,
                    $txn->customer_cvc,
                    $txn->customer_expiry_date,
                    $txn->amount,
                    strtoupper($txn->status),
                    $txn->created_at ? $txn->created_at->format('Y-m-d H:i:s') : 'N/A'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
