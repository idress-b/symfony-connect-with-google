<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GoogleController extends AbstractController
{
    #[Route("/connect/google", name: "connect_google_start")]
    public function connectAction(ClientRegistry $clientRegistry)
    {
        return $clientRegistry
            ->getClient('google')
            ->redirect([
                'profile', 'email' // the scopes you want to access
            ], []);
    }

    #[Route("/connect/google/check", name: "connect_google_check")]
    public function connectCheckAction(Request $request, ClientRegistry $clientRegistry)
    {
        $client = $clientRegistry->getClient('google');
        try {
            $user = $client->fetchUser();
            dd($user);
        } catch (IdentityProviderException $e) {
            // something went wrong!
            // probably you should return the reason to the user
            var_dump($e->getMessage());
            die;
        }
    }
}
