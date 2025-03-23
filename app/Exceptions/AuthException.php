<?php

namespace App\Exceptions;

use Exception;

class AuthException extends Exception
{
    private const TYPE = 'AuthException';
    private array $details;

    private function __construct(
        private string $type,
        string $message,
    ) {
        parent::__construct($message);

        $this->details = [];
    }

    public static function notAuthorized()
    {
        return new static(
            implode('.', [static::TYPE, 'notAuthorized']),
            'Não autorizado a acessar este recurso!',
        );
    }

    public function getType()
    {
        return $this->type;
    }

    public function getDetails()
    {
        return $this->details;
    }
}
