<?php

namespace App\Helpers\Response;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class FormatResponse
{
    static function success($data = null, $message = 'request.successful', $status = 'SUCCESS', $status_code = Response::HTTP_OK, $responseField = 'data'): JsonResponse
    {
        return self::create_response($data, __($message), $status, $status_code, [], $responseField);
    }

    static function failed($message = 'request.failed', $status_code = Response::HTTP_BAD_REQUEST, $status = 'FAILED'): JsonResponse
    {
        return self::create_response(null, __($message), $status, $status_code);
    }

    static function failed_validator(Validator $validator, $status = 'FAILED'): JsonResponse
    {
        return self::create_response(
            key($validator->errors()->messages()),
            current($validator->errors()->messages())[0],
            $status, Response::HTTP_BAD_REQUEST, [], "field"
        );
    }

    static function forbidden($message = 'request.forbidden', $status = 'ERROR'): JsonResponse
    {
        return self::failed(__($message), $status, Response::HTTP_FORBIDDEN);
    }

    static function not_found($message = 'request.not_found', $status = 'ERROR'): JsonResponse
    {
        return self::failed(__($message), $status, Response::HTTP_NOT_FOUND);
    }

    static function invalid_credentials($message = 'auth.failed', $status = 'ERROR'): JsonResponse
    {
        return self::failed(__($message), $status, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    static function unauthorized($message = 'request.unauthorized', $status = 'ERROR'): JsonResponse
    {
        return self::failed(__($message), $status, Response::HTTP_UNAUTHORIZED);
    }

    static function internal_error($message = 'request.internal_error', $status = 'ERROR'): JsonResponse
    {
        return self::failed(__($message), $status, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    static function create_response($data, string $message, string $status, int $status_code, array $headers = [], $responseField = 'data'): JsonResponse
    {
        return self::json([
            "status" => $status,
            "message" => __($message),
            $responseField => $data
        ], $status_code, $headers);
    }

    static function json($payload, int $status_code = Response::HTTP_OK, array $headers = []): JsonResponse
    {
        return response()->json($payload, $status_code, $headers);
    }
}
