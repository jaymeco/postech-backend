<?php

namespace Core\Domain\Base\Enums;

enum CategoryEnum: string
{
    case SNACK = '4236e27e-6fbe-494d-8777-edf2161f9d7d';
    case DRINK = 'ff25c138-3d7e-48cf-bb82-b9c072ebf2c6';
    case DESSERT = 'ab18f0d5-7967-48ea-9443-9f297ee07ff4';
    case GARNISH = 'dad0bb0e-87b0-40ad-870d-7f98eaf3529e';

    public function key()
    {
        return $this->value;
    }

    public function name()
    {
        return match ($this) {
            self::SNACK => 'Lanche',
            self::DRINK => 'Bebida',
            self::DESSERT => 'Sobremesa',
            self::GARNISH => 'Acompanhamento',
        };
    }
}
