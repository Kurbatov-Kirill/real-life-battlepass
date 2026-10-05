<?php

namespace App\Controller;

use App\Entity\Battlepass;
use App\Entity\Profile;
use App\Repository\BattlepassRepository;
use App\Service\BattlepassService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BattlepassController extends AbstractController
{
    #[Route('/battlepasses', name: 'app_battlepass_index', methods: ['GET'])]
    public function index(BattlepassRepository $repository): Response
    {
        /** @var Profile $user */
        $user = $this->getUser();
        $myBattlepasses = $repository->findAllForUser($user);

        return $this->render('battlepass/index.html.twig', [
            'battlepasses' => $myBattlepasses,
        ]);
    }

    #[Route('/battlepasses', name: 'app_battlepass_create', methods: ['POST'])]
    public function new(Request $request, BattlepassService $bpService): Response
    {
        if (!$this->isCsrfTokenValid('battlepass_create', $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Невалидный токен!');
        }
        try {
            $bpService->create(
                $this->getUser(),
                $request->request->get('title'),
                $request->request->get('opponent_email'),
                $request->request->get('start_date'),
                $request->request->get('end_date')
            );
        } catch (\InvalidArgumentException $e) {
            return new Response($e->getMessage(), 400);
        }

        return $this->redirectToRoute('app_battlepass_index');
    }

    #[Route('/battlepasses/{id}', name: 'app_battlepass_show', methods: ['GET'])]
    public function show(Battlepass $battlepass): Response
    {
        if ($battlepass->getPlayer1() !== $this->getUser() && $battlepass->getPlayer2() !== $this->getUser()) {
            throw $this->createAccessDeniedException('Вы не являетесь участником этого батлпасса!');
        }

        if ($battlepass->getStatus() === \App\Enum\BattlepassStatus::PENDING) {
            $this->addFlash('warning', 'Этот батлпасс еще не активен. Дождитесь подтверждения напарника!');
            return $this->redirectToRoute('app_battlepass_index');
        }

        $opponent = $battlepass->getPlayer1() === $this->getUser()
            ? $battlepass->getPlayer2()
            : $battlepass->getPlayer1();

        return $this->render('battlepass/show.html.twig', [
            'battlepass' => $battlepass,
            'opponent' => $opponent,
        ]);
    }

    #[Route('/battlepasses/{id}/accept', name: 'app_battlepass_accept', methods: ['POST'])]
    public function accept(Battlepass $battlepass, EntityManagerInterface $em): Response
    {
        if ($battlepass->getPlayer2() !== $this->getUser()) {
            throw $this->createAccessDeniedException('Вы не можете принять чужое приглашение!');
        }

        $battlepass->setStatus(\App\Enum\BattlepassStatus::ACTIVE);
        $em->flush();

        $this->addFlash('success', 'Батлпасс теперь активен!');

        return $this->redirectToRoute('app_battlepass_index');
    }

    #[Route('/battlepasses/{id}/decline', name: 'app_battlepass_decline', methods: ['POST'])]
    public function decline(Battlepass $battlepass, EntityManagerInterface $em): Response
    {
        if ($battlepass->getPlayer2() !== $this->getUser()) {
            throw $this->createAccessDeniedException('Вы не можете отклонить чужое приглашение!');
        }

        $battlepass->setStatus(\App\Enum\BattlepassStatus::DECLINED);
        $em->flush();

        $this->addFlash('warning', 'Приглашение в батлпасс было отклонено.');

        return $this->redirectToRoute('app_battlepass_index');
    }
}
