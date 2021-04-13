<?php declare(strict_types=1);

namespace App\Http;

class Response
{
    public static function successView(string $view, $data)
    {
        return view($view, $data);
    }
}
