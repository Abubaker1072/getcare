<?php

namespace App\Helpers;

class ImageHelper
{
    /**
     * Get product image URL with fallback
     */
    public static function getProductImage($filename)
    {
        $path = public_path("products/{$filename}");
        
        if (file_exists($path)) {
            return asset("products/{$filename}");
        }

        // Return placeholder images based on filename
        $placeholders = [
            'led-light.jpg' => 'https://images.unsplash.com/photo-1598184954389-ebdc0a2b72e2?w=500&h=600&fit=crop',
            'anti-aging.jpg' => 'https://images.unsplash.com/photo-1556228578-8c89e6adf883?w=500&h=600&fit=crop',
            'anti-acne.jpg' => 'https://images.unsplash.com/photo-1556743212-5612639fdc67?w=500&h=600&fit=crop',
            'all-devices.jpg' => 'https://images.unsplash.com/photo-1596643206863-0c6688de1fbb?w=500&h=600&fit=crop',
            'before-after-1.jpg' => 'https://images.unsplash.com/photo-1544161515-81290573fba3?w=400&h=300&fit=crop',
            'before-after-2.jpg' => 'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?w=400&h=300&fit=crop',
            'before-after-3.jpg' => 'https://images.unsplash.com/photo-1552058544-f151b9c4a67e?w=400&h=300&fit=crop',
            'before-after-4.jpg' => 'https://images.unsplash.com/photo-1561746015-06b4694b13d2?w=400&h=300&fit=crop',
            'before-after-5.jpg' => 'https://images.unsplash.com/photo-1561121327-c226200588db?w=400&h=300&fit=crop',
            'avatar-1.jpg' => 'https://i.pravatar.cc/40?img=1',
            'avatar-2.jpg' => 'https://i.pravatar.cc/40?img=2',
            'avatar-3.jpg' => 'https://i.pravatar.cc/40?img=3',
            'avatar-4.jpg' => 'https://i.pravatar.cc/40?img=4',
            'avatar-5.jpg' => 'https://i.pravatar.cc/40?img=5',
            'product-1.jpg' => 'https://images.unsplash.com/photo-1598184954389-ebdc0a2b72e2?w=400&h=400&fit=crop',
            'product-2.jpg' => 'https://images.unsplash.com/photo-1596217797304-a44edd78a10a?w=400&h=400&fit=crop',
            'product-3.jpg' => 'https://images.unsplash.com/photo-1608248543803-ba4f8c70ae0b?w=400&h=400&fit=crop',
            'product-4.jpg' => 'https://images.unsplash.com/photo-1608963311513-f5c61ee69c6c?w=400&h=400&fit=crop',
            'product-5.jpg' => 'https://images.unsplash.com/photo-1609209769842-b45e28109d1a?w=400&h=400&fit=crop',
            'product-6.jpg' => 'https://images.unsplash.com/photo-1600643081563-430f63602022?w=400&h=400&fit=crop',
            'product-7.jpg' => 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?w=400&h=400&fit=crop',
            'product-8.jpg' => 'https://images.unsplash.com/photo-1611930022073-b7a4ba5fcccd?w=400&h=400&fit=crop',
        ];

        return $placeholders[$filename] ?? 'https://via.placeholder.com/400';
    }
}
