<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ExoController extends AbstractController
{
    #[Route('/exo/filtertwig', name: 'app_exo')]
    public function twigfilters(): Response
    {
        return $this->render('exo/exo.html.twig');
    }
}
