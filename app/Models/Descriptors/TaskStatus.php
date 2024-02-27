<?php

declare(strict_types=1);

namespace App\Models\Descriptors;

use App\Models\Descriptors\Traits\Arrayable;

enum TaskStatus: string
{
    use Arrayable;

    case PENDING = 'pending';

    case IN_PROGRESS = 'in progress';

    case COMPLETED = 'completed';
}
