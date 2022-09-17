<?php

if (!function_exists('generalResponse')) {

    function generalResponse($success, $data, $message = null, int $statusCode = 200)
    {
        return (new \App\Helper\ApiResponse())->generalResponse($success, $data, $message, $statusCode);
    }
}
