<?php

namespace App\Modules\Transactions\Enums;

enum TransactionStatus: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case FAILED = 'failed';
    case CANCELLED = 'cancelled';
    case REJECTED = 'rejected';
    case APPROVED = 'approved';
}
