<?php

namespace App\Http\Utils;

use Gate;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\MessageBag;

class Error
{
    public const NOT_FOUND = 404;
    public const UNAUTHORIZED = 401;
    public const FORBIDDEN = 403;
    public const INVALID_DATA = 422;
    public const INTERNAL_SERVER_ERROR = 500;

    public int $httpCode;
    public string $message;
    public string $failurePoint;

    private string $file;
    private int $line;
    private string $function;
    private string $class;

    public function __construct(string $message, int $httpCode)
    {
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
        $this->file = $trace[0]['file'];
        $this->line = $trace[0]['line'];
        $this->function = $trace[1]['function'];
        $this->class = $trace[1]['class'];
        $this->httpCode = $httpCode;
        $this->message = $message;

        $this->failurePoint = $this->getPointOfFailure();
    }

    public function response(): JsonResponse
    {
        return self::makeResponse($this->message, $this->httpCode, $this->failurePoint);
    }

    public static function makeResponse(string | MessageBag $message = 'Something went wrong', int $httpCode = 500, string $failurePoint = ''): JsonResponse
    {
        $response = [
            'error' => $message,
            'code' => $httpCode
        ];
        if (Gate::allows('view-point-of-failure')) {
            $response['failure_point'] = $failurePoint;
        }
        return response()->json($response, $httpCode);
    }

    public function getPointOfFailure(): string {
        return self::makeFormattedPointOfFailure($this->file, $this->line, $this->class, $this->function);
    }

    public static function getTraceAndMakePointOfFailure(): string {
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
        return self::makeFormattedPointOfFailure($trace[0]['file'], $trace[0]['line'], $trace[1]['class'], $trace[1]['function']);
    }

    public static function makeFormattedPointOfFailure(string $file, int $line, string $class, string $function): string {
        return "Error occurred in {$file} at line {$line}, in function/method {$class}::{$function}";
    }
}
