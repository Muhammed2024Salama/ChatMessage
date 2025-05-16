<?php

namespace App\Helper;

use Illuminate\Http\JsonResponse;

class ResponseHelper
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * @param $status string
     * @param $message string
     * @param $data array
     * @param $statusCode integer
     * @return JsonResponse
     */
    public static function success($status = 'success', $message = null, $data = [], $statusCode = 200): JsonResponse
    {
        return new JsonResponse(
            [
                'status' => $status,
                'message' => $message,
                'data' => $data,
            ],
            $statusCode
        );
    }

    /**
     * @param $success
     * @param $message
     * @param $data
     * @param $status
     * @param $error
     * @return JsonResponse
     */
    public static function sendResponse($success, $message, $data = [], $status = 200, $error = null)

    {
        return response()->json([
            'meta' => [
                'success' => $success,
                'message' => $message,
                'status' => $status
            ],
            'data' => $data,
            'error' => $error
        ], $status);
    }

    /**
     * @param $status string
     * @param $message string
     * @param $statusCode integer
     * @return JsonResponse
     * Function : Common function to display error - Json Response
     */
    public static function error($status = 'error', $message = null, $statusCode = 400): JsonResponse
    {
        return new JsonResponse(
            [
                'status' => $status,
                'message' => $message,
            ],
            $statusCode
        );
    }
}
