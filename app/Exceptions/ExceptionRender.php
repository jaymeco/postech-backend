<?php

namespace App\Exceptions;

use App\Constants\ErrorTypes;
use App\Constants\HttpStatus;
use Throwable;

class ExceptionRender
{
    private function __construct(
        public readonly string $type,
        public readonly string $message,
        private readonly int $status,
        public readonly array $details,
        public readonly ?\Throwable $previous = null,
    ) {}

    public static function render(Throwable $exception)
    {
        $renderer =  match ($exception::class) {
            RequestException::class => self::request($exception),
            default => self::unResolved($exception),
        };

        return response()->json($renderer, $renderer->status);
    }

    public function getData() {
    }

    private static function request(RequestException $exception)
    {
        return new static(
            ErrorTypes::validation()->type,
            ErrorTypes::validation()->message,
            HttpStatus::BAD_REQUEST,
            $exception->getDetails(),
        );
    }

    private static function unResolved(Throwable $exception)
    {
        return new static(
            ErrorTypes::validation()->type,
            ErrorTypes::validation()->message,
            HttpStatus::INTERNAL_SERVER_ERROR,
            [],
            $exception->getPrevious()
        );
    }
}
