<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Product review videos:\n";
foreach (\App\Models\Product::has('reviewVideos')->withCount('reviewVideos')->get() as $p) {
    echo "- " . $p->name . ": " . $p->review_videos_count . " videos\n";
}

echo "\nHomepage reels:\n";
$regularReels = \App\Models\Reel::with('product')->where('is_active', true)->latest()->get();
$productReels = \App\Models\ProductReviewVideo::with('product')->where('is_active', true)->where('show_on_homepage', true)->latest()->get();
$reels = $regularReels->concat($productReels)->sortByDesc('created_at')->values();
echo "Total loaded: " . $reels->count() . "\n";
foreach ($reels as $r) {
    echo "  * Source: " . get_class($r) . ", Caption: " . $r->caption . ", Product: " . ($r->product ? $r->product->name : 'None') . "\n";
}
