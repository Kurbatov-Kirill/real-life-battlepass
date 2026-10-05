<?php

namespace App\Twig\Runtime;

use App\Entity\Profile;
use App\Repository\NotificationRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Twig\Extension\RuntimeExtensionInterface;

class AppExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private NotificationRepository $notificationRepo,
        private Security $security
    ) {}

    public function getUnreadNotifications(): array
    {
        $user = $this->security->getUser();

        if (!$user) {
            return [];
        }

        /** @var Profile $user */
        return $this->notificationRepo->findUnreadForUser($user);
    }
}
