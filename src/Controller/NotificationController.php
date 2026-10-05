<?php

namespace App\Controller;

use App\Entity\Notification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NotificationController extends AbstractController
{
    #[Route('/notifications/{id}/go', name: 'app_notification_go', methods: ['GET'])]
    public function go(Notification $notification, EntityManagerInterface $em): Response
    {
        if ($notification->getTarget() !== $this->getUser()) {
            throw $this->createAccessDeniedException('Вы не можете читать чужие уведомления!');
        }

        $notification->setIsRead(true);
        $em->flush();

        $targetUrl = $notification->getUrl();

        if (!$targetUrl) {
            return $this->redirectToRoute('app_home');
        }

        return $this->redirect($targetUrl);
    }
}
