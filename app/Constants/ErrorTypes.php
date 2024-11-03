<?php

namespace App\Constants;

class ErrorTypes
{
    private function __construct(
        public readonly string $type,
        public readonly string $message,
    ) {}

    public static function validation()
    {
        return new static('ValidationError', 'Os dados enviados estao invalidos');
    }

    public static function unexpected()
    {
        return new static('InternalError', 'Ocorreu um erro inesperado');
    }
}
