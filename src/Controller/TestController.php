<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TestController
{
    #[Route('/')]
    public function greet()
    {
        return new Response('Hello World Fixed!');
    }
}
