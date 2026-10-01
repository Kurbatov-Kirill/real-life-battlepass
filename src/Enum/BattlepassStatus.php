<?php

namespace App\Enum;

enum BattlepassStatus: string
{
    case PENDING = 'pending';
    case ACTIVE = 'active';
    case DECLINED = 'declined';
    case FINISHED = 'finished';
}
