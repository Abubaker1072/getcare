<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test admin can toggle review homepage visibility.
     */
    public function test_admin_can_toggle_review_homepage_visibility(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@getcare.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        $review = Review::create([
            'name' => 'John Reviewer',
            'rating' => 5,
            'title' => 'Great product',
            'text' => 'Loved using this beauty mask!',
            'is_approved' => true,
            'show_on_homepage' => false,
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.reviews.toggle_homepage', $review->id));

        $response->assertRedirect();
        $this->assertTrue($review->fresh()->show_on_homepage);

        $response = $this->actingAs($admin)
            ->post(route('admin.reviews.toggle_homepage', $review->id));

        $response->assertRedirect();
        $this->assertFalse($review->fresh()->show_on_homepage);
    }

    /**
     * Test flagged reviews are shown on homepage.
     */
    public function test_flagged_reviews_are_shown_on_homepage(): void
    {
        $review = Review::create([
            'name' => 'Sarah Visible',
            'rating' => 5,
            'title' => 'Outstanding result',
            'text' => 'This changed my skincare routine!',
            'is_approved' => true,
            'show_on_homepage' => true,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Sarah Visible');
        $response->assertSee('Outstanding result');
    }
}
