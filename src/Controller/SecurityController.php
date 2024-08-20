<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SecurityController extends AbstractController
{
    public const SCOPES = [
        'google' => []

    ];

    #[Route('/login', name: 'auth_oauth_login')]
    public function login(): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        return $this->render('security/login.html.twig');
    }

    #[Route('/logout', name: 'auth_oauth_logout', methods: ['GET'])]
    public function logout(): void
    {
        throw new \Exception('This should never be reached!');
    }

    #[Route('oauth/connect/{service}', name: 'auth_oauth_connect', methods: ['GET'])]
    public function connect(string $service, ClientRegistry $clientRegistry): RedirectResponse
    {
        if (! in_array($service, array_keys(self::SCOPES), true)) {
            throw $this->createNotFoundException();
        }

        return $clientRegistry->getClient($service)->redirect(self::SCOPES[$service], []);
    }

    #[Route('oauth/check/{service}', name: 'auth_oauth_check', methods: ['GET', 'POST'])]
    public function check(): Response
    {
        return new Response(status: 200);
    }
}
