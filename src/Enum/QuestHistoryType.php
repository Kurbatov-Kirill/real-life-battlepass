<?php

namespace App\Enum;

enum QuestHistoryType: string
{
    case CREATION = 'creation';
    case TEXT = 'text';
    case MODIFICATION = 'modification';
    case SUBMISSION = 'submission';
    case REJECTION = 'rejection';
    case APPROVAL = 'approval';
    case FAILURE = 'failure';
}
