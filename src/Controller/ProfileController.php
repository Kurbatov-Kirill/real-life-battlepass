<?php

namespace App\Controller;

use App\Entity\Profile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(): Response
    {
        /** @var Profile|null $profile */
        $profile = $this->getUser();

        if (!$profile) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('profile/view.html.twig', [
            'profile' => $profile,
            'is_my_profile' => true
        ]);
    }

    #[Route('/profile/{id}', name: 'app_profile_show')]
    public function show(Profile $profile): Response
    {
        return $this->render('profile/view.html.twig', [
            'profile' => $profile,
        ]);
    }
}
