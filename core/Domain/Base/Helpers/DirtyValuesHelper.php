<?php

namespace Core\Domain\Base\Helpers;

abstract class DirtyValuesHelper
{
    public static function resolve($original, $new = null)
    {
        if (!is_null($new) && $new == $original) {
            return $new;
        }

        return $original;
    }
}
