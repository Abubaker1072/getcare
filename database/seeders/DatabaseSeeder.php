<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Prevent duplicates for Admin
        if (!User::where('email', 'abubakerkhadim79@gmail.com')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'abubakerkhadim79@gmail.com',
                'password' => bcrypt('123123'),
                'is_admin' => true,
            ]);
        }

        \App\Models\Currency::updateOrCreate(
            ['code' => 'PKR'],
            ['symbol' => '₨', 'exchange_rate' => 1.000000, 'is_default' => true, 'is_active' => true]
        );
        \App\Models\Currency::updateOrCreate(
            ['code' => 'USD'],
            ['symbol' => '$', 'exchange_rate' => 0.003600, 'is_default' => false, 'is_active' => true]
        );
        \App\Models\Currency::updateOrCreate(
            ['code' => 'USDT'],
            ['symbol' => '$', 'exchange_rate' => 0.003600, 'is_default' => false, 'is_active' => true]
        );
        \App\Models\Currency::updateOrCreate(
            ['code' => 'GBP'],
            ['symbol' => '£', 'exchange_rate' => 0.002800, 'is_default' => false, 'is_active' => true]
        );
        \App\Models\Currency::updateOrCreate(
            ['code' => 'EUR'],
            ['symbol' => '€', 'exchange_rate' => 0.003300, 'is_default' => false, 'is_active' => true]
        );
        \App\Models\Currency::updateOrCreate(
            ['code' => 'CAD'],
            ['symbol' => 'C$', 'exchange_rate' => 0.004900, 'is_default' => false, 'is_active' => true]
        );

        // Seed default approved reviews/testimonials
        $defaultReviews = [
            [
                'name' => 'Eleanor R.',
                'rating' => 5,
                'title' => 'Absolutely Transformative',
                'text' => 'Within three weeks of using the LED protocol alongside the 24K serum, my fine lines have visibly diminished. The clinical quality is undeniable.',
                'product_name' => 'Clinical Renewal Bundle',
                'is_approved' => true
            ],
            [
                'name' => 'Sophia M.',
                'rating' => 5,
                'title' => 'My Secret Weapon',
                'text' => 'I no longer need professional facials. This device provides an instant lift that lasts all day. The packaging and experience are pure luxury.',
                'product_name' => 'Microcurrent Device',
                'is_approved' => true
            ],
            [
                'name' => 'Claire T.',
                'rating' => 5,
                'title' => 'Gentle yet Powerful',
                'text' => 'Finally, a retinol formulation that doesn\'t irritate my sensitive skin. Waking up to a glowing, plump complexion has become my new normal.',
                'product_name' => 'Advanced Retinol Duo',
                'is_approved' => true
            ],
            [
                'name' => 'Isabella L.',
                'rating' => 4,
                'title' => 'Spa Results at Home',
                'text' => 'The extraction mode cleared my pores in a way I didn\'t think was possible outside of a dermatologist\'s office. Worth every penny.',
                'product_name' => 'Ultrasonic Skin Scrubber',
                'is_approved' => true
            ]
        ];

        foreach ($defaultReviews as $rev) {
            \App\Models\Review::updateOrCreate(
                ['title' => $rev['title'], 'name' => $rev['name']],
                $rev
            );
        }

        // Seed an initial customer message
        \App\Models\CustomerMessage::updateOrCreate(
            ['email' => 'jane.doe@example.com', 'first_name' => 'Jane'],
            [
                'first_name' => 'Jane',
                'last_name' => 'Doe',
                'email' => 'jane.doe@example.com',
                'inquiry_type' => 'consultation',
                'message' => 'Hello, I have sensitive, acne-prone skin and I am looking for the best LED light therapy device. Could you please recommend which option from your catalogue would suit my skin type best? Thank you!',
                'is_read' => false
            ]
        );
    }
}
