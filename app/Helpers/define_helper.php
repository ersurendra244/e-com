<?php
if (!function_exists('fileTypeIcon')) {
    function fileTypeIcon($fileName)
    {
        $fileTypeIcons = [
            'jpg' => '🖼️', 'jpeg' => '🖼️', 'png' => '🖼️', 'gif' => '🖼️', 'svg' => '🖼️',
            'webp' => '🖼️', 'ico' => '🖼️', 'bmp' => '🖼️', 'tif' => '🖼️', 'tiff' => '🖼️', 'avif' => '🖼️',
            'txt' => '📄', 'html' => '🌐', 'php' => '🐘', 'js' => '🟨', 'css' => '🎨',
            'pdf' => '📕', 'doc' => '📝', 'docx' => '📝', 'xls' => '📊', 'xlsx' => '📊',
            'ppt' => '📈', 'pptx' => '📈',
            'mp4' => '🎬', 'avi' => '🎬', 'mov' => '🎬', 'webm' => '🎬', 'mkv' => '🎬',
            'mp3' => '🎧', 'wav' => '🎧', 'aac' => '🎧', 'ogg' => '🎧', 'flac' => '🎧',
            'zip' => '🗜️', 'rar' => '🗜️', '7z' => '🗜️', 'tar' => '🗜️', 'gz' => '🗜️',
            'folder' => '📁',
        ];

        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (empty($extension)) {
            return $fileTypeIcons['folder'];
        }

        return $fileTypeIcons[$extension] ?? $fileTypeIcons['folder'];
    }
}


if (!function_exists('priceRange')) {
    function priceRange()
    {
        return [
            '1' => '500 - 1000',
            '2' => '1000 - 2000',
            '3' => '2000 - 3000',
            '4' => '3000 - 4000',
            '5' => '4000 - 5000',
            '6' => '6000 - 30000',
        ];
    }
}

if (!function_exists('colors')) {
    function colors()
    {
        return [
            'Black'  => 'Black',
            'White'  => 'White',
            'Red'    => 'Red',
            'Blue'   => 'Blue',
            'Green'  => 'Green',
        ];
    }
}
if (!function_exists('sizes')) {
    function sizes()
    {
        return [
            'XS'  => 'XS',
            'SM'  => 'SM',
            'MD'  => 'MD',
            'LG'  => 'LG',
            'XL'  => 'XL',
            'XXL' => 'XXL',
        ];
    }
}

if (!function_exists('footwear_sizes')) {
    function footwear_sizes()
    {
        return [
            '2'  => '2',
            '3'  => '3',
            '4'  => '4',
            '5'  => '5',
            '6'  => '6',
            '7'  => '7',
            '8'  => '8',
            '9'  => '9',
            '10'  => '10',
            '11'  => '11',
            '12' => '12',
            '13' => '13',
            '14' => '14',
        ];
    }
}
if (!function_exists('occasions')) {
    function occasions()
    {
        return [
            'Casual'  => 'Casual',
            'Casual'  => 'Casual',
            'Ethnic'  => 'Ethnic',
            'Formal'  => 'Formal',
            'Party'  => 'Party',
            'Riding'  => 'Riding',
            'Sports'  => 'Sports',
            'Wedding'  => 'Wedding',
        ];
    }
}
if (!function_exists('screen_sizes')) {
    function screen_sizes()
    {
        return [
            '24 inch & Below'  => '24 inch & Below',
            '28 - 32 inch'  => '28 - 32 inch',
            '40 - 43 inch'  => '40 - 43 inch',
            '50 - 55 inch'  => '50 - 55 inch',
            '60 - 65 inch'  => '60 - 65 inch',
            '70 - 75 inch' => '70 - 75 inch',
        ];
    }
}

if (!function_exists('resolutions')) {
    function resolutions()
    {
        return [
            'Full HD'  => 'Full HD',
            'HD Ready'  => 'HD Ready',
            'Ultra HD (4K)'  => 'Ultra HD (4K)',
            'Ultra HD (8K)'  => 'Ultra HD (8K)',
        ];
    }
}
if (!function_exists('video_resolutions')) {
    function video_resolutions()
    {
        return [
            '1280 x 720'  => '1280 x 720',
            '1920 x 1080'  => '1920 x 1080',
            '3328 x 2496'  => '3328 x 2496',
            '3840 x 2160'  => '3840 x 2160',
            '4896 x 3264'  => '4896 x 3264',
            '5472 x 3648'  => '5472 x 3648',
            '6000 x 3164'  => '6000 x 3164',
            '6240 x 4160'  => '6240 x 4160',
            '7680 x 4320'  => '7680 x 4320',
            '8688 x 5792'  => '8688 x 5792',
        ];
    }
}
