<?php

namespace App\Enum;

enum QuestStatus: string
{
    case ACTIVE = 'active';
    case PENDING_REVIEW = 'pending_review';
    case COMPLETED = 'completed';
    case FAILED = 'failed';
}
