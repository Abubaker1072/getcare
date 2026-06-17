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
        if ($layoutJson) {
            $layout = json_decode($layoutJson, true);
            if (is_array($layout) && count($layout) > 0) {
                return $layout;
            }
        }

        return [
            ['id' => 'hero', 'name' => 'Hero Section', 'visible' => true],
            ['id' => 'complete_routine', 'name' => 'Complete Routine Set', 'visible' => true],
            ['id' => 'categories', 'name' => 'Featured Collections', 'visible' => true],
            ['id' => 'products', 'name' => 'Bestselling Products', 'visible' => true],
            ['id' => 'reels', 'name' => 'Professional Reels', 'visible' => true],
            ['id' => 'brand_marquee', 'name' => 'Brand Logos Marquee', 'visible' => true],
            ['id' => 'skin_edit', 'name' => 'The Skin Edit (Blog)', 'visible' => true],
            ['id' => 'why_choose_us', 'name' => 'Why Choose Us', 'visible' => true],
            ['id' => 'testimonials', 'name' => 'Testimonials', 'visible' => true],
            ['id' => 'features_strip', 'name' => 'Features/Benefits Strip', 'visible' => true],
        ];
    }
}
