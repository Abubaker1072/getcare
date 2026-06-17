<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\CartItem;
use App\Models\StoreSetting;
use App\Models\PaymentGateway;
use App\Models\PaymentTransaction;
use App\Services\PaymentProcessingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentGatewayTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Setup default configuration
        StoreSetting::setValue('cod_is_active', '0'); // Disable COD to force gateway
        StoreSetting::setValue('bank_is_active', '1');
        StoreSetting::setValue('shipping_is_active', '0');
    }

    public function test_payment_processing_service_simulates_balance_check_properly()
    {
        $gatewayRepo = app(\App\Repositories\Contracts\PaymentGatewayRepositoryInterface::class);
        $transactionRepo = app(\App\Repositories\Contracts\PaymentTransactionRepositoryInterface::class);
        $service = new PaymentProcessingService($gatewayRepo, $transactionRepo);

        // Success test (account does not end in 9 or contain fail)
        $successResult = $service->processPayment(100.0, [
            'customer_bank_name' => 'Meezan',
            'customer_account_number' => 'PK12MEZN123456780',
            'customer_account_holder' => 'John Doe',
            'customer_cvc' => '123',
            'customer_expiry_date' => '12/29',
        ]);
        $this->assertTrue($successResult['success']);
        $this->assertEquals('success', $successResult['status']);

        // Failed test (ends in 9)
        $failResult9 = $service->processPayment(150.0, [
            'customer_bank_name' => 'HBL',
            'customer_account_number' => 'PK12MEZN123456789',
            'customer_account_holder' => 'Jane Smith',
            'customer_cvc' => '321',
            'customer_expiry_date' => '10/28',
        ]);
        $this->assertFalse($failResult9['success']);
        $this->assertEquals('insufficient_balance', $failResult9['status']);

        // Failed test (contains 'fail')
        $failResultWord = $service->processPayment(200.0, [
            'customer_bank_name' => 'HBL',
            'customer_account_number' => 'PK12MEZN-fail-123',
            'customer_account_holder' => 'Jane Smith',
            'customer_cvc' => '321',
            'customer_expiry_date' => '10/28',
        ]);
        $this->assertFalse($failResultWord['success']);
        $this->assertEquals('insufficient_balance', $failResultWord['status']);

        // Assert database has recorded these transactions
        $this->assertDatabaseHas('payment_transactions', [
            'customer_account_number' => 'PK12MEZN123456780',
            'status' => 'success',
            'amount' => 100.00
        ]);

        $this->assertDatabaseHas('payment_transactions', [
            'customer_account_number' => 'PK12MEZN123456789',
            'status' => 'failed',
            'amount' => 150.00
        ]);
    }

    public function test_checkout_failed_payment_does_not_create_order_due_to_insufficient_balance()
    {
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Skincare Devices',
            'slug' => 'skincare-devices',
            'is_active' => true,
        ]);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'LED Light Therapy Mask',
            'slug' => 'led-light-therapy-mask',
            'price' => 50.0,
            'stock' => 10,
            'is_active' => true,
        ]);

        CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $response = $this->actingAs($user)->post(route('checkout.store'), [
            'shipping_name' => 'Recipient Name',
            'shipping_phone' => '03001234567',
            'shipping_address' => 'Recipient Address',
            'payment_method' => 'bank',
            'customer_bank_name' => 'HBL',
            'customer_account_number' => 'PK12MEZN123456789', // Ends in 9 (insufficient balance)
            'customer_account_holder' => 'Jane Doe',
            'customer_cvc' => '456',
            'customer_expiry_date' => '05/27',
        ]);

        // Should redirect back to checkout index
        $response->assertStatus(302);
        $response->assertSessionHas('insufficient_balance');

        // Order should not be created
        $this->assertEquals(0, Order::count());
        // Cart should still exist
        $this->assertEquals(1, CartItem::count());
        // Stock should not be decremented
        $product->refresh();
        $this->assertEquals(10, $product->stock);
    }

    public function test_checkout_successful_payment_creates_order_and_payment_transaction()
    {
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Skincare Devices',
            'slug' => 'skincare-devices',
            'is_active' => true,
        ]);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'LED Light Therapy Mask',
            'slug' => 'led-light-therapy-mask',
            'price' => 50.0,
            'stock' => 10,
            'is_active' => true,
        ]);

        CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $response = $this->actingAs($user)->post(route('checkout.store'), [
            'shipping_name' => 'Recipient Name',
            'shipping_phone' => '03001234567',
            'shipping_address' => 'Recipient Address',
            'payment_method' => 'bank',
            'customer_bank_name' => 'HBL',
            'customer_account_number' => 'PK12MEZN123456780', // Ends in 0 (success)
            'customer_account_holder' => 'Jane Doe',
            'customer_cvc' => '456',
            'customer_expiry_date' => '05/27',
        ]);

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('success');

        // Order should be created and marked paid
        $this->assertEquals(1, Order::count());
        $order = Order::first();
        $this->assertEquals('paid', $order->payment_status);

        // Cart should be cleared
        $this->assertEquals(0, CartItem::count());
        // Stock should be decremented
        $product->refresh();
        $this->assertEquals(8, $product->stock);

        // Transaction log check
        $this->assertDatabaseHas('payment_transactions', [
            'order_id' => $order->id,
            'customer_account_number' => 'PK12MEZN123456780',
            'status' => 'success',
            'amount' => 100.00
        ]);
    }

    public function test_admin_can_download_payment_transactions_csv()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        // Create transaction logs
        PaymentTransaction::create([
            'customer_bank_name' => 'HBL',
            'customer_account_number' => 'PK12MEZN123456780',
            'customer_account_holder_name' => 'Test User',
            'customer_cvc' => '111',
            'customer_expiry_date' => '02/30',
            'amount' => 500.00,
            'status' => 'success',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.payment-gateways.download'));

        $response->assertStatus(200);
        $this->assertStringContainsString('text/csv', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('PK12MEZN123456780', $response->streamedContent());
        $this->assertStringContainsString('Test User', $response->streamedContent());
    }

    public function test_customer_can_manage_saved_payment_gateway_details()
    {
        $user = User::factory()->create();

        // 1. Visit dashboard, should not have bank details saved yet
        $response = $this->actingAs($user)->get(route('dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Saved Gateway Details');

        // 2. Submit bank details update form
        $updateResponse = $this->actingAs($user)->post(route('dashboard.bank-details.update'), [
            'bank_name' => 'Meezan Bank',
            'account_number' => 'PK99MEZN0011223344',
            'account_holder_name' => 'Alice Bob',
            'cvc' => '999',
            'expiry_date' => '11/33',
        ]);

        $updateResponse->assertRedirect();
        $updateResponse->assertSessionHas('success');

        // 3. Verify it is saved in database and linked to user
        $this->assertDatabaseHas('user_bank_details', [
            'user_id' => $user->id,
            'bank_name' => 'Meezan Bank',
            'account_number' => 'PK99MEZN0011223344',
            'account_holder_name' => 'Alice Bob',
            'cvc' => '999',
            'expiry_date' => '11/33',
        ]);

        // 4. Verify checkout pre-fills this details
        $category = Category::create([
            'name' => 'Skincare Devices',
            'slug' => 'skincare-devices',
            'is_active' => true,
        ]);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'LED Light Therapy Mask',
            'slug' => 'led-light-therapy-mask',
            'price' => 50.0,
            'stock' => 10,
            'is_active' => true,
        ]);
        CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $checkoutResponse = $this->actingAs($user)->get(route('checkout.index'));
        $checkoutResponse->assertStatus(200);
        $checkoutResponse->assertSee('PK99MEZN0011223344');
        $checkoutResponse->assertSee('Alice Bob');
        $checkoutResponse->assertSee('999');
        $checkoutResponse->assertSee('11/33');
    }
}
