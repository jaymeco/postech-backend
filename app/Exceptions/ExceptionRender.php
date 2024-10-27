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
    ) {}

    public static function render(Throwable $exception)
    {
        $renderer =  match ($exception::class) {
            RequestException::class => self::request($exception),
            ApplicationException::class => self::application($exception),
            default => self::unResolved($exception),
        };

        return response()->json($renderer, $renderer->status);
    }

    public function getData() {}

    private static function request(RequestException $exception)
    {
        return new static(
            ErrorTypes::validation()->type,
            ErrorTypes::validation()->message,
            HttpStatus::BAD_REQUEST,
            $exception->getDetails(),
        );
    }

    private static function application(ApplicationException $exception)
    {
        return new static(
            $exception->getType(),
            $exception->getMessage(),
            HttpStatus::NOT_FOUND,
            $exception->getDetails(),
        );
    }

    private static function unResolved(Throwable $exception)
    {
        return new static(
            ErrorTypes::unexpected()->type,
            ErrorTypes::unexpected()->message,
            HttpStatus::INTERNAL_SERVER_ERROR,
            self::buildPrevious($exception),
        );
    }

    private static function buildPrevious(Throwable $exception)
    {
        $details = [
            'error' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ];

        if (!is_null($exception->getPrevious())) {
            $details['previous'] = self::buildPrevious($exception->getPrevious());
        }

        return $details;
    }
}
