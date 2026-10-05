<?php

namespace App\EventSubscriber;

use App\Entity\Notification;
use App\Enum\NotificationType;
use App\Event\BattlepassCreatedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BattlepassNotificationSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private EntityManagerInterface $em
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            BattlepassCreatedEvent::NAME => 'onCreate',
        ];
    }

    public function onCreate(BattlepassCreatedEvent $event): void
    {
        $battlepass = $event->getBattlepass();
        $creator = $battlepass->getPlayer1();
        $partner = $battlepass->getPlayer2();

        $notification = new Notification();
        $notification->setTarget($partner);
        $notification->setType(NotificationType::BATTLEPASS_INVITATION_RECEIVED);
        $notification->setTitle('Новое приглашение в БП!');
        $notification->setMessage("Игрок {$creator->getUsername()} приглашает вас в БП «{$battlepass->getTitle()}»");
        $notification->setUrl("/battlepasses/{$battlepass->getId()}");

        $this->em->persist($notification);
        $this->em->flush();
    }
}
