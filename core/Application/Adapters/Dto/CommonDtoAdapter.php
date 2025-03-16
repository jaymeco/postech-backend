<?php

namespace Core\Application\Adapters\Dto;

use Core\Application\Dtos\CommonDto;

abstract class CommonDtoAdapter
{
    public static function parse(mixed $data)
    {
        return new CommonDto(
            $data->getUuid()->getValue(),
            $data->getName()->getValue(),
        );
    }
}
