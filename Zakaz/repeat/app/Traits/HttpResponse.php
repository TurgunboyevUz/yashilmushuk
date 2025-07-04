<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait HttpResponse
{
    /**
     * Success message http response json
     *
     * @param  array|string  $data
     * @param  int  $code
     * @return JsonResponse
     */
    protected function success($data = [], $code = 200, $message = '')
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'result' => $data,
        ], $code);
    }

    /**
     * Error message http response json
     *
     * @param  array|string  $data
     * @param  int  $code
     * @return JsonResponse
     */
    protected function error($message = '', $code = 400, $data = [])
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'result' => $data,
        ], $code);
    }
}
