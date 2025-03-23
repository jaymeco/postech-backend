<?php

namespace Core\Domain\Base\Enums;

enum PaymentStatus: string
{
    case WAITING = 'AGUARDANDO_PAGAMENTO';
    case APPROVED = 'PAGAMENTO_APROVADO';
    case REFUSED = 'PAGAMENTO_RECUSADO';
    case CANCELLED = 'PAGAMENTO_CANCELADO';
}
