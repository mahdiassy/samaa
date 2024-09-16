<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Response;

class ApiResponse
{
    public static function notFoundResponse($message="Not found")
    {
        return response()->json([
            'success' => false,
            'data' => [],
            'message' => $message,
        ], Response::HTTP_NOT_FOUND);
    }

    public static function successResponse($data, $message = 'Ok')
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ], Response::HTTP_OK);
    }

    public static function serverErrorResponse($message = 'Server Error')
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public static function invalidDataResponse($message = 'Invalid data')
    {
        return \response()->json([
            'success' => false,
            'message' => $message,
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public static function unAuthorizedResponse($message = 'Unauthorized')
    {
        return \response()->json([
           'success' => false,
           'message' => $message
        ], Response::HTTP_UNAUTHORIZED);
    }
}
