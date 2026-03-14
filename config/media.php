<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Image Processing Driver
    |--------------------------------------------------------------------------
    |
    | Supported drivers: "gd" (default, included in PHP) or "imagick"
    | (requires the ImageMagick extension).
    |
    | To switch to ImageMagick:
    |   1. Install: `apt install php-imagick` / `brew install imagemagick`
    |   2. Set in .env: IMAGE_DRIVER=imagick
    |
    */

    'image_driver' => env('IMAGE_DRIVER', 'gd'),

    /*
    |--------------------------------------------------------------------------
    | Maximum Image Width (px)
    |--------------------------------------------------------------------------
    |
    | Images wider than this value will be resized proportionally.
    |
    */

    'max_width' => (int) env('IMAGE_MAX_WIDTH', 1920),

    /*
    |--------------------------------------------------------------------------
    | JPEG Encoding Quality
    |--------------------------------------------------------------------------
    |
    | Quality percentage used when re-encoding images. Range: 1–100.
    |
    */

    'encode_quality' => (int) env('IMAGE_ENCODE_QUALITY', 85),

];
