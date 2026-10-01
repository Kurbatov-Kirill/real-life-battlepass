<?php

namespace App\Enum;

enum NotificationType: string
{
    case BATTLEPASS_INVITATION_RECEIVED = 'battlepass_invite_received';
    case BATTLEPASS_INVITATION_ACCEPTED = 'battlepass_invitation_accepted';
    case BATTLEPASS_INVITATION_DECLINED = 'battlepass_invitation_declined';
    case BATTLEPASS_STARTED = 'battlepass_started';
    case BATTLEPASS_FINISHED = 'battlepass_finished';
    case QUEST_CREATED = 'quest_created';
    case QUEST_APPROVED = 'quest_approved';
    case QUEST_REJECTED = 'quest_rejected';
    case QUEST_COMPLETED = 'quest_completed';
    case QUEST_MODIFIED = 'quest_modified';
    case QUEST_FAILED = 'quest_failed';
}
