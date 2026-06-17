<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - GetCare</title>
</head>
<body style="margin: 0; padding: 0; background-color: #faf9f6; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333333; -webkit-font-smoothing: antialiased;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #faf9f6; padding: 40px 0;">
        <tr>
            <td align="center">
                <!-- Email container -->
                <table border="0" cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border: 1px solid #e8e6e1; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.02);">
                    
                    <!-- Header Banner -->
                    <tr>
                        <td align="center" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); padding: 50px 40px; text-align: center;">
                            <h1 style="color: #f59e0b; font-family: 'Georgia', serif; font-size: 32px; font-weight: 300; margin: 0; letter-spacing: 0.1em; text-transform: uppercase;">GetCare</h1>
                            <p style="color: #94a3b8; font-size: 13px; font-weight: 500; margin: 10px 0 0 0; letter-spacing: 0.2em; text-transform: uppercase;">Order Confirmed</p>
                        </td>
                    </tr>
                    
                    <!-- Content Area -->
                    <tr>
                        <td style="padding: 40px 40px 30px 40px;">
                            <h2 style="font-family: 'Georgia', serif; font-size: 24px; color: #0f172a; margin-top: 0; font-weight: normal; line-height: 1.3;">Thank you for your order!</h2>
                            <p style="font-size: 15px; line-height: 1.6; color: #4b5563; margin-bottom: 24px;">
                                Hello {{ $order->shipping_name }}, your order **#{{ $order->order_number }}** has been received and is currently being processed. Below is a detailed summary of your purchase.
                            </p>
                            
                            <!-- Order Info Grid -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 30px; border-collapse: collapse;">
                                <tr>
                                    <td width="50%" style="padding-right: 10px; vertical-align: top;">
                                        <h4 style="font-family: 'Georgia', serif; font-size: 14px; color: #0f172a; margin: 0 0 8px 0; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #f3f4f6; padding-bottom: 4px;">Shipping Details</h4>
                                        <p style="font-size: 13px; line-height: 1.5; color: #4b5563; margin: 0;">
                                            <strong>{{ $order->shipping_name }}</strong><br>
                                            {{ $order->shipping_address }}<br>
                                            Phone: {{ $order->shipping_phone }}
                                        </p>
                                    </td>
                                    <td width="50%" style="padding-left: 10px; vertical-align: top;">
                                        <h4 style="font-family: 'Georgia', serif; font-size: 14px; color: #0f172a; margin: 0 0 8px 0; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #f3f4f6; padding-bottom: 4px;">Payment Method</h4>
                                        <p style="font-size: 13px; line-height: 1.5; color: #4b5563; margin: 0;">
                                            Method: {{ $order->payment_method === 'cod' ? 'Cash on Delivery (COD)' : 'Bank Transfer' }}<br>
                                            Status: <span style="text-transform: capitalize;">{{ $order->payment_status }}</span>
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Order Items Table -->
                            <h4 style="font-family: 'Georgia', serif; font-size: 15px; color: #0f172a; margin: 0 0 12px 0; text-transform: uppercase; letter-spacing: 0.05em;">Items Ordered</h4>
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 30px; border-collapse: collapse;">
                                <thead>
                                    <tr style="border-bottom: 2px solid #e8e6e1;">
                                        <th align="left" style="padding: 10px 0; font-size: 13px; color: #94a3b8; font-weight: 600; text-transform: uppercase;">Product</th>
                                        <th align="center" style="padding: 10px 0; font-size: 13px; color: #94a3b8; font-weight: 600; text-transform: uppercase;">Qty</th>
                                        <th align="right" style="padding: 10px 0; font-size: 13px; color: #94a3b8; font-weight: 600; text-transform: uppercase;">Price</th>
                                        <th align="right" style="padding: 10px 0; font-size: 13px; color: #94a3b8; font-weight: 600; text-transform: uppercase;">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $subtotal = 0;
                                    @endphp
                                    @foreach($order->items as $item)
                                        @php
                                            $itemTotal = $item->price * $item->quantity;
                                            $subtotal += $itemTotal;
                                        @endphp
                                        <tr style="border-bottom: 1px solid #f3f4f6;">
                                            <td style="padding: 12px 0; font-size: 14px; color: #0f172a;">
                                                @if($item->product)
                                                    <strong>{{ $item->product->name }}</strong>
                                                @else
                                                    <strong>Product Details Unavailable</strong>
                                                @endif
                                            </td>
                                            <td align="center" style="padding: 12px 0; font-size: 14px; color: #4b5563;">
                                                {{ $item->quantity }}
                                            </td>
                                            <td align="right" style="padding: 12px 0; font-size: 14px; color: #4b5563;">
                                                {{ \App\Helpers\CurrencyHelper::formatForOrder($item->price, $order) }}
                                            </td>
                                            <td align="right" style="padding: 12px 0; font-size: 14px; color: #0f172a; font-weight: 600;">
                                                {{ \App\Helpers\CurrencyHelper::formatForOrder($itemTotal, $order) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    
                                    <!-- Totals Section -->
                                    <tr>
                                        <td colspan="2"></td>
                                        <td align="right" style="padding: 12px 0 6px 0; font-size: 14px; color: #4b5563;">Subtotal:</td>
                                        <td align="right" style="padding: 12px 0 6px 0; font-size: 14px; color: #0f172a; font-weight: 600;">
                                            {{ \App\Helpers\CurrencyHelper::formatForOrder($subtotal, $order) }}
                                        </td>
                                    </tr>
                                    @php
                                        $shippingFee = $order->total_amount - $subtotal;
                                    @endphp
                                    <tr>
                                        <td colspan="2"></td>
                                        <td align="right" style="padding: 6px 0; font-size: 14px; color: #4b5563;">Shipping Fee:</td>
                                        <td align="right" style="padding: 6px 0; font-size: 14px; color: #0f172a; font-weight: 600;">
                                            {{ \App\Helpers\CurrencyHelper::formatForOrder($shippingFee, $order) }}
                                        </td>
                                    </tr>
                                    <tr style="border-top: 1px solid #e8e6e1;">
                                        <td colspan="2"></td>
                                        <td align="right" style="padding: 12px 0; font-size: 16px; color: #0f172a; font-weight: bold;">Grand Total:</td>
                                        <td align="right" style="padding: 12px 0; font-size: 16px; color: #f59e0b; font-weight: bold;">
                                            {{ \App\Helpers\CurrencyHelper::formatForOrder($order->total_amount, $order) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            @if($order->payment_method === 'bank')
                                <!-- Bank payment details / instructions -->
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 30px; background-color: #faf9f6; border-left: 4px solid #f59e0b; border-radius: 4px;">
                                    <tr>
                                        <td style="padding: 15px 20px;">
                                            <h5 style="font-family: 'Georgia', serif; font-size: 14px; color: #0f172a; margin: 0 0 8px 0; font-weight: bold;">Bank Transfer Action Required</h5>
                                            <p style="font-size: 13px; line-height: 1.5; color: #4b5563; margin: 0;">
                                                Please transfer the total amount of <strong>{{ \App\Helpers\CurrencyHelper::formatForOrder($order->total_amount, $order) }}</strong> from your account (<strong>{{ $order->customer_bank_name }} - {{ $order->customer_account_number }}</strong>) to complete the checkout.
                                            </p>
                                            @php
                                                $storeBankDetails = \App\Models\StoreSetting::getValue('bank_details', '');
                                            @endphp
                                            @if($storeBankDetails)
                                                <p style="font-size: 13px; line-height: 1.5; color: #4b5563; margin-top: 8px; margin-bottom: 0;">
                                                    <strong>Store Bank Details:</strong><br>
                                                    {!! nl2br(e($storeBankDetails)) !!}
                                                </p>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            @endif

                            <hr style="border: 0; border-top: 1px solid #f3f4f6; margin: 30px 0;">
                            
                            <!-- CTA or note -->
                            <p style="font-size: 14px; line-height: 1.6; color: #6b7280; margin-bottom: 0; text-align: center;">
                                You can track your order status in your <a href="{{ url('/dashboard') }}" style="color: #f59e0b; text-decoration: none; font-weight: 600;">Customer Dashboard</a>.
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background-color: #faf9f6; padding: 30px 40px; text-align: center; border-top: 1px solid #e8e6e1;">
                            <p style="color: #9ca3af; font-size: 12px; margin: 0 0 8px 0;">&copy; {{ date('Y') }} GetCare. All rights reserved.</p>
                            <p style="color: #d1d5db; font-size: 11px; margin: 0;">If you have any questions, reply to this email or contact us at info@getcare.pk</p>
                        </td>
                    </tr>
                    
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
