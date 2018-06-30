<?php

define('DS', DIRECTORY_SEPARATOR);

if (!function_exists('config_path')) {
    /**
     * Return the path to config files
     * @param null $path
     * @return string
     */
    function config_path($path = null)
    {
        return app()->getConfigurationPath(rtrim($path, '.php'));
    }
}
if (!function_exists('public_path')) {
    /**
     * Return the path to public dir
     * @param null $path
     * @return string
     */
    function public_path($public = null)
    {
        return rtrim(app()->basePath('public/' . $public), '/');
    }
}
if (!function_exists('storage_path')) {
    /**
     * Return the path to storage dir
     * @param null $path
     * @return string
     */
    function storage_path($path = null)
    {
        return app()->storagePath($path);
    }
}
if (!function_exists('database_path')) {
    /**
     * Return the path to database dir
     * @param null $path
     * @return string
     */
    function database_path($path = null)
    {
        return app()->databasePath($path);
    }
}
if (!function_exists('resource_path')) {
    /**
     * Return the path to resource dir
     * @param null $path
     * @return string
     */
    function resource_path($path = null)
    {
        return app()->resourcePath($path);
    }
}
if (!function_exists('asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string $path
     * @param  bool $secure
     * @return string
     */
    function asset($path, $secure = null)
    {
        return app('url')->asset($path, $secure);
    }
}
if (!function_exists('elixir')) {
    /**
     * Get the path to a versioned Elixir file.
     *
     * @param  string $file
     * @return string
     */
    function elixir($file)
    {
        static $manifest = null;
        if (is_null($manifest)) {
            $manifest = json_decode(file_get_contents(public_path() . '/build/rev-manifest.json'), true);
        }
        if (isset($manifest[$file])) {
            return '/build/' . $manifest[$file];
        }
        throw new InvalidArgumentException("File {$file} not defined in asset manifest.");
    }
}
if (!function_exists('auth')) {
    /**
     * Get the available auth instance.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    function auth()
    {
        return app('Illuminate\Contracts\Auth\Guard');
    }
}
if (!function_exists('bcrypt')) {
    /**
     * Hash the given value.
     *
     * @param  string $value
     * @param  array $options
     * @return string
     */
    function bcrypt($value, $options = [])
    {
        return app('hash')->make($value, $options);
    }
}
if (!function_exists('response')) {
    /**
     * Return a new response from the application.
     *
     * @param  string $content
     * @param  int $status
     * @param  array $headers
     * @return \Symfony\Component\HttpFoundation\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    function response($content = '', $status = 200, array $headers = [])
    {
        $factory = app('Illuminate\Contracts\Routing\ResponseFactory');
        if (func_num_args() === 0) {
            return $factory;
        }
        return $factory->make($content, $status, $headers);
    }
}
if (!function_exists('secure_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string $path
     * @return string
     */
    function secure_asset($path)
    {
        return asset($path, true);
    }
}
if (!function_exists('secure_url')) {
    /**
     * Generate a HTTPS url for the application.
     *
     * @param  string $path
     * @param  mixed $parameters
     * @return string
     */
    function secure_url($path, $parameters = [])
    {
        return url($path, $parameters, true);
    }
}
if (!function_exists('session')) {
    /**
     * Get / set the specified session value.
     *
     * If an array is passed as the key, we will assume you want to set an array of values.
     *
     * @param  array|string $key
     * @param  mixed $default
     * @return mixed
     */
    function session($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('session');
        }
        if (is_array($key)) {
            return app('session')->put($key);
        }
        return app('session')->get($key, $default);
    }
}
if (!function_exists('cookie')) {
    /**
     * Create a new cookie instance.
     *
     * @param  string $name
     * @param  string $value
     * @param  int $minutes
     * @param  string $path
     * @param  string $domain
     * @param  bool $secure
     * @param  bool $httpOnly
     * @return \Symfony\Component\HttpFoundation\Cookie
     */
    function cookie(
        $name = null,
        $value = null,
        $minutes = 0,
        $path = null,
        $domain = null,
        $secure = false,
        $httpOnly = true
    ) {
        $cookie = app('Illuminate\Contracts\Cookie\Factory');
        if (is_null($name)) {
            return $cookie;
        }
        return $cookie->make($name, $value, $minutes, $path, $domain, $secure, $httpOnly);
    }
}

/**
 * @param $string
 * @param bool $gost
 * @return string
 */
function translatable($string, $gost = false)
{
    if ($gost) {
        $replace = [
            'А' => 'A',
            'а' => 'a',
            'Б' => 'B',
            'б' => 'b',
            'В' => 'V',
            'в' => 'v',
            'Г' => 'G',
            'г' => 'g',
            'Д' => 'D',
            'д' => 'd',
            'Е' => 'E',
            'е' => 'e',
            'Ё' => 'E',
            'ё' => 'e',
            'Ж' => 'Zh',
            'ж' => 'zh',
            'З' => 'Z',
            'з' => 'z',
            'И' => 'I',
            'и' => 'i',
            'Й' => 'I',
            'й' => 'i',
            'К' => 'K',
            'к' => 'k',
            'Л' => 'L',
            'л' => 'l',
            'М' => 'M',
            'м' => 'm',
            'Н' => 'N',
            'н' => 'n',
            'О' => 'O',
            'о' => 'o',
            'П' => 'P',
            'п' => 'p',
            'Р' => 'R',
            'р' => 'r',
            'С' => 'S',
            'с' => 's',
            'Т' => 'T',
            'т' => 't',
            'У' => 'U',
            'у' => 'u',
            'Ф' => 'F',
            'ф' => 'f',
            'Х' => 'Kh',
            'х' => 'kh',
            'Ц' => 'Tc',
            'ц' => 'tc',
            'Ч' => 'Ch',
            'ч' => 'ch',
            'Ш' => 'Sh',
            'ш' => 'sh',
            'Щ' => 'Shch',
            'щ' => 'shch',
            'Ы' => 'Y',
            'ы' => 'y',
            'Э' => 'E',
            'э' => 'e',
            'Ю' => 'Iu',
            'ю' => 'iu',
            'Я' => 'Ia',
            'я' => 'ia',
            'ъ' => '',
            'ь' => ''
        ];
    } else {
        $arStrES = ['ае', 'уе', 'ое', 'ые', 'ие', 'эе', 'яе', 'юе', 'ёе', 'ее', 'ье', 'ъе', 'ый', 'ий'];
        $arStrOS = ['аё', 'уё', 'оё', 'ыё', 'иё', 'эё', 'яё', 'юё', 'ёё', 'её', 'ьё', 'ъё', 'ый', 'ий'];
        $arStrRS = ['а$', 'у$', 'о$', 'ы$', 'и$', 'э$', 'я$', 'ю$', 'ё$', 'е$', 'ь$', 'ъ$', '@', '@'];

        $replace = [
            'А' => 'A',
            'а' => 'a',
            'Б' => 'B',
            'б' => 'b',
            'В' => 'V',
            'в' => 'v',
            'Г' => 'G',
            'г' => 'g',
            'Д' => 'D',
            'д' => 'd',
            'Е' => 'Ye',
            'е' => 'e',
            'Ё' => 'Ye',
            'ё' => 'e',
            'Ж' => 'Zh',
            'ж' => 'zh',
            'З' => 'Z',
            'з' => 'z',
            'И' => 'I',
            'и' => 'i',
            'Й' => 'Y',
            'й' => 'y',
            'К' => 'K',
            'к' => 'k',
            'Л' => 'L',
            'л' => 'l',
            'М' => 'M',
            'м' => 'm',
            'Н' => 'N',
            'н' => 'n',
            'О' => 'O',
            'о' => 'o',
            'П' => 'P',
            'п' => 'p',
            'Р' => 'R',
            'р' => 'r',
            'С' => 'S',
            'с' => 's',
            'Т' => 'T',
            'т' => 't',
            'У' => 'U',
            'у' => 'u',
            'Ф' => 'F',
            'ф' => 'f',
            'Х' => 'Kh',
            'х' => 'kh',
            'Ц' => 'Ts',
            'ц' => 'ts',
            'Ч' => 'Ch',
            'ч' => 'ch',
            'Ш' => 'Sh',
            'ш' => 'sh',
            'Щ' => 'Shch',
            'щ' => 'shch',
            'Ъ' => '',
            'ъ' => '',
            'Ы' => 'Y',
            'ы' => 'y',
            'Ь' => '',
            'ь' => '',
            'Э' => 'E',
            'э' => 'e',
            'Ю' => 'Yu',
            'ю' => 'yu',
            'Я' => 'Ya',
            'я' => 'ya',
            '@' => 'y',
            '$' => 'ye'
        ];

        $string = str_replace($arStrES, $arStrRS, $string);
        $string = str_replace($arStrOS, $arStrRS, $string);
    }

    return iconv('UTF-8', 'UTF-8//IGNORE', strtr($string, $replace));
}

/**
 * @param $string
 * @return string
 */
function productCategory($string)
{
    $replace = [
        'Суши и роллы' => 'sushi-rolly',
        'Мега-роллы' => 'mega_rolly',
        'Сеты' => 'sety',
        'Пицца' => 'pizza',
        'Салаты' => 'salaty',
        'Десерты' => 'deserty',
        'Напитки' => 'napitki',
        'Доп.ингридиенты' => 'dop'
    ];

    return strtr($string, $replace);
}
