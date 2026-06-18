<?php
$content = file_get_contents(__DIR__ . '/resources/views/pages/dashboard.blade.php');

// Split orders
preg_match('/<div id="tab-orders" class="tab-content text-left">(.*?)<\/div>\s*{{-- Tab 1\.5/s', $content, $matches);
if (isset($matches[1])) file_put_contents(__DIR__ . '/resources/views/pages/dashboard/orders.blade.php', $matches[1]);

// Split completed
preg_match('/<div id="tab-completed" class="tab-content hidden text-left">(.*?)<\/div>\s*{{-- Tab 2/s', $content, $matches);
if (isset($matches[1])) file_put_contents(__DIR__ . '/resources/views/pages/dashboard/completed.blade.php', $matches[1]);

// Split messages
preg_match('/<div id="tab-messages" class="tab-content hidden text-left">(.*?)<\/div>\s*{{-- Tab/s', $content, $matches);
if (isset($matches[1])) file_put_contents(__DIR__ . '/resources/views/pages/dashboard/messages.blade.php', $matches[1]);

// Split payment
preg_match('/<div id="tab-payment" class="tab-content hidden text-left">(.*?)<\/div>\s*{{-- Tab 3/s', $content, $matches);
if (isset($matches[1])) file_put_contents(__DIR__ . '/resources/views/pages/dashboard/payment.blade.php', $matches[1]);

// Split password
preg_match('/<div id="tab-password" class="tab-content hidden text-left">(.*?)<\/div>\s*<\/div>\s*<\/div>\s*<script>/s', $content, $matches);
if (isset($matches[1])) file_put_contents(__DIR__ . '/resources/views/pages/dashboard/security.blade.php', $matches[1]);

echo "Done\n";
