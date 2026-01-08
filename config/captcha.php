<?php

return [
    'disable' => env('CAPTCHA_DISABLE', false),
   // 'characters' => ['2', '3', '4', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'j', 'm', 'n', 'p', 'q', 'r', 't', 'u', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'M', 'N', 'P', 'Q', 'R', 'T', 'U', 'X', 'Y', 'Z'],
    'characters' => ['1','2', '3', '4', '6', '7', '8', '9', '0'],
    'default' => [
        'length' => 5,
        'width' => 150,
        'height' => 36,
        'quality' => 90,
        'math' => false,
        'lines' => 0,
        'expire' => 60,
        'bgColor' => '#ecf2f4',
        'fontColors' => ['#2c3e50', '#c0392b', '#16a085', '#c0392b', '#8e44ad', '#303f9f', '#f57c00', '#795548'],
        'encrypt' => false,
    ]
];
