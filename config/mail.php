<?php
return [

    'driver' => env('MAIL_DRIVER', 'smtp'),

    'host' => env('MAIL_HOST', 'smtp.yandex.com'),

    'port' => env('MAIL_PORT', 465),

    'from' => ['address' => 'webmaster@mapcheckin.ru', 'name' => 'Sashimi59'],

    'encryption' => env('MAIL_ENCRYPTION', 'ssl'),

    'username' => env('MAIL_USERNAME'),

    'password' => env('MAIL_PASSWORD'),

    'sendmail' => '/usr/sbin/sendmail -bs',

    'pretend' => false,

    'secret' => env('MAIL_API_KEY'),

];