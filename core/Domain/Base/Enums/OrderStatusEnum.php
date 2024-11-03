<?php

namespace Core\Domain\Base\Enums;

enum OrderStatusEnum: string
{
    case CREATED = '4236e27e-6fbe-494d-8777-edf2161f9d7d';
    case RECEIVED = 'ff25c138-3d7e-48cf-bb82-b9c072ebf2c6';
    case PREPARING = 'ab18f0d5-7967-48ea-9443-9f297ee07ff4';
    case READY = 'dad0bb0e-87b0-40ad-870d-7f98eaf3529e';
    case FINISHED = '971b321f-745a-4f20-8a10-1c4f7b8ff72d';

    public function key()
    {
        return $this->value;
    }

    public function name()
    {
        return match ($this) {
            self::CREATED => 'Pedido criado',
            self::RECEIVED => 'Pedido recebido',
            self::PREPARING => 'Pedido em preparacao',
            self::READY => 'Pedido pronto',
            self::FINISHED => 'Pedido finalizado',
        };
    }
}
