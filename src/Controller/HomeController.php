<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class HomeController extends AbstractController
{
    #[Route("/", name: "home")]
    public function index()
    {
        return $this->render('home/index.html.twig');
    }
}
