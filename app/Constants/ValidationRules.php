<?php

namespace App\Constants;

class ValidationRules
{
    private const ATTRIBUTE = ':attribute';

    const REQUIRED = self::ATTRIBUTE . '.required';
    const TYPE = self::ATTRIBUTE . '.invalid_type';
}
