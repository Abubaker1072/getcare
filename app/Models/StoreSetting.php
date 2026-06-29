<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreSetting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Get setting value by key.
     */
    public static function getValue($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Set setting value by key.
     */
    public static function setValue($key, $value)
    {
        return self::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    /**
     * Get the homepage layout configuration.
     */
    public static function getHomepageLayout()
    {
        $layoutJson = self::getValue('homepage_layout');
        $layout = [];
        if ($layoutJson) {
            $layout = json_decode($layoutJson, true);
        }

        $defaultLayout = [
            ['id' => 'hero', 'name' => 'Hero Section', 'visible' => true],
            ['id' => 'category_quick_nav', 'name' => 'Category Quick Navigation', 'visible' => true],
            ['id' => 'complete_routine', 'name' => 'Complete Routine Set', 'visible' => true],
            ['id' => 'categories', 'name' => 'Featured Collections', 'visible' => true],
            ['id' => 'flash_sale_banner', 'name' => 'Flash Sale Countdown Banner', 'visible' => true],
            ['id' => 'products', 'name' => 'Bestselling Products', 'visible' => true],
            ['id' => 'reels', 'name' => 'Professional Reels', 'visible' => true],
            ['id' => 'brand_marquee', 'name' => 'Brand Logos Marquee', 'visible' => true],
            ['id' => 'skin_edit', 'name' => 'The Skin Edit (Blog)', 'visible' => true],
            ['id' => 'why_choose_us', 'name' => 'Why Choose Us', 'visible' => true],
            ['id' => 'testimonials', 'name' => 'Testimonials', 'visible' => true],
            ['id' => 'features_strip', 'name' => 'Features/Benefits Strip', 'visible' => true],
        ];

        if (is_array($layout) && count($layout) > 0) {
            // Ensure any new default sections that don't exist in saved layout are merged back in
            $existingIds = array_column($layout, 'id');
            foreach ($defaultLayout as $sec) {
                if (!in_array($sec['id'], $existingIds)) {
                    // Try to insert it relative to its index in default layout
                    $index = array_search($sec['id'], array_column($defaultLayout, 'id'));
                    array_splice($layout, $index, 0, [$sec]);
                }
            }
            return $layout;
        }

        return $defaultLayout;
    }
}
