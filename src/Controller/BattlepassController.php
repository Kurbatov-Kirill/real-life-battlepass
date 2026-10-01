<?php

namespace App\Controller;

use App\Service\BattlepassService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BattlepassController extends AbstractController
{
    #[Route('/battlepasses', name: 'app_battlepass_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('battlepass/index.html.twig', [
            'controller_name' => 'BattlepassController',
        ]);
    }

    #[Route('/battlepasses', name: 'app_battlepass_create', methods: ['POST'])]
    public function new(Request $request, BattlepassService $bpService): Response
    {
        if (!$this->isCsrfTokenValid('battlepass_create', $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Невалидный тоken!');
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
}
