<?php

namespace Payme\Http\Classes;

class Response
{
    public array $response = [];


    public static function success($data = [])
    {
        
    }

    public static function error($code, $message = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $code);
    }
}