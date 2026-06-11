# Product Images Directory

This folder contains all product images for the GetCare beauty store.

## Required Images

### Category Images (Featured Collections)
- `led-light.jpg` - LED Light Therapy products (recommended: 500x600px)
- `anti-aging.jpg` - Anti-Aging products (recommended: 500x600px)
- `anti-acne.jpg` - Anti-Acne products (recommended: 500x600px)
- `all-devices.jpg` - All Devices collection (recommended: 500x600px)

### Before & After Images (Testimonials)
- `before-after-1.jpg` - Fine Lines, Dullness transformation
- `before-after-2.jpg` - Aging, Wrinkles transformation
- `before-after-3.jpg` - Inflammation, Redness transformation
- `before-after-4.jpg` - Fine Lines, Sun Damage transformation
- `before-after-5.jpg` - Saggy Skin transformation

### User Avatar Images
- `avatar-1.jpg` - Sarah M. (recommended: 40x40px)
- `avatar-2.jpg` - Emma L. (recommended: 40x40px)
- `avatar-3.jpg` - Jessica T. (recommended: 40x40px)
- `avatar-4.jpg` - Michelle K. (recommended: 40x40px)
- `avatar-5.jpg` - Rachel P. (recommended: 40x40px)

### Product Images (Best Sellers)
- `product-1.jpg` - Premium LED Mask
- `product-2.jpg` - Anti-Aging Serum
- `product-3.jpg` - Facial Cleansing Brush
- `product-4.jpg` - Microneedle Roller
- `product-5.jpg` - Hydrating Face Mask
- `product-6.jpg` - Ultra Sonic Pen
- `product-7.jpg` - Gold Eye Patches
- `product-8.jpg` - Vitamin C Brightener

## Using Placeholder Images

While waiting for real product images, you can use placeholder images. The application will gracefully fallback to gradient backgrounds if images are missing.

### Recommended Placeholder Services:
1. **Unsplash** - https://unsplash.com/
2. **Pexels** - https://www.pexels.com/
3. **Pixabay** - https://pixabay.com/

### Download Instructions:
1. Search for relevant skincare/beauty product images
2. Download in high quality (at least 800x600px)
3. Save to this folder with the corresponding filename
4. Ensure image quality is professional and consistent

## Image Specifications

- **Format**: JPG or PNG
- **Color Profile**: sRGB
- **Quality**: High resolution (800x600px minimum)
- **File Size**: Optimize to under 500KB per image
- **Aspect Ratio**: Maintain 16:10 for product images, 1:1 for avatars

## Organizing Images

Keep this structure clean:
```
public/products/
├── led-light.jpg
├── anti-aging.jpg
├── anti-acne.jpg
├── all-devices.jpg
├── before-after-1.jpg
├── before-after-2.jpg
├── before-after-3.jpg
├── before-after-4.jpg
├── before-after-5.jpg
├── avatar-1.jpg
├── avatar-2.jpg
├── avatar-3.jpg
├── avatar-4.jpg
├── avatar-5.jpg
├── product-1.jpg
├── product-2.jpg
├── product-3.jpg
├── product-4.jpg
├── product-5.jpg
├── product-6.jpg
├── product-7.jpg
└── product-8.jpg
```

## Notes

- All images will display with graceful fallbacks using gradient backgrounds
- If an image fails to load, the gradient color scheme will still display
- Update image filenames in the blade templates if you change file names
- Compress images after uploading to optimize load times
