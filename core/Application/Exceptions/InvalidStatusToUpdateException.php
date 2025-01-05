<?php

namespace Core\Application\Exceptions;

use Exception;

class InvalidStatusToUpdateException extends Exception
{
    private function __construct(
        string $message,
        public readonly string $resource
    ) {
        parent::__construct($message);
    }

    public static function throw()
    {
        throw new static('Status do pedido inválido para executar esta operação', 'order');
    }
}
