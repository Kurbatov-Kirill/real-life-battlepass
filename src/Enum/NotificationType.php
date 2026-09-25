<?php

namespace App\Enum;

enum NotificationType: string
{
    case QUEST_CREATED = 'quest_created';
    case QUEST_APPROVED = 'quest_approved';
    case QUEST_REJECTED = 'quest_rejected';
    case QUEST_COMPLETED = 'quest_completed';
    case QUEST_MODIFIED = 'quest_modified';
    case QUEST_FAILED = 'quest_failed';
}
