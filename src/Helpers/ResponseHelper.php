<?php

namespace FaisalHalim\LaravelEklaimApi\Helpers;

class ResponseHelper
{
    /**
     * Membuat respons kesalahan standar.
     *
     * @param int $code
     * @param string $message
     * @return string
     */
    public static function error($message = 'Internal Server Error', $code = 500)
    {
        return json_encode([
            'metadata' => [
                'code'    => $code,
                'message' => $message,
            ],
        ]);
    }

    /**
     * Mendekode respons JSON ke array.
     *
     * @param string $response
     * @return array
     */
    public static function decode($response)
    {
        return json_decode($response, true);
    }
}
