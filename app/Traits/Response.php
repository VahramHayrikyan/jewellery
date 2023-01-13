<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

Trait Response
{

    /**
     * @param array $params
     * @param int $code
     * @return JsonResponse
     */
    public static function success($params = [], $code = 200): JsonResponse
    {
        $response = [
            'status' => 'success',
            'data'    => $params
        ];

        return response()->json($response, $code);
    }

    /**
     * @param array $params
     * @param int $code
     * @return JsonResponse
     */
    public static function error($params = [], $code = 400): JsonResponse
    {
        $response = [
            'status' => 'failure',
            'data'    => $params
        ];

        return response()->json($response, $code);
    }
}
