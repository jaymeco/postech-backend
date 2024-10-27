<?php

namespace App\Exceptions;

use Exception;

class ApplicationException extends Exception
{
    private const TYPE = 'ApplicationException';
    private array $details;

    private function __construct(
        private string $type,
        private string $exceptionMessage,
    ) {
        $this->details = [];
    }

    public static function notFound(string $resource, ?string $field = null)
    {
        $exception = new static(
            static::TYPE,
            'Recurso solicitado nao encontrado'
        );

        $exception->addDetail(['resource' => $resource, 'field' => $field]);

        return $exception;
    }

    private function addDetail(array $detail)
    {
        $this->details[] = $detail;
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
