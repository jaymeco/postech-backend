<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Contracts\Validation\Validator;

class RequestException extends Exception
{
    private function __construct(
        private array $errors,
    ) {}

    public static function create(Validator $validator)
    {
        $errors = [];
        foreach ($validator->errors()->all() as $error) {
            [$field, $rule] = explode('.', $error);
            $errors[] = [
                'field' => $field,
                'rule' => $rule,
            ];
        }

        return new static($errors);
    }

    public function getDetails()
    {
        return $this->errors;
    }
}
