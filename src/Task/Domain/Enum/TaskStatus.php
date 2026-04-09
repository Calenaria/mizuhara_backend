<?php

namespace App\Task\Domain\Enum;

enum TaskStatus: string
{
    case NEW = 'NEW';
    case IN_PROGRESS = 'IN_PROGRESS';
    case SUSPENDED = 'SUSPENDED';
    case COMPLETED = 'COMPLETED';
}
