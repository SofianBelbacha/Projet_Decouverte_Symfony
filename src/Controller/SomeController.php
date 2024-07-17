<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SomeController extends AbstractController
{
    #[Route('/some', name: 'app_some')]
    public function index(): Response
    {
        return $this->render('some/index.html.twig', [
            'controller_name' => 'SomeController',
        ]);
    }

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    #[Route('/debug-user', name: 'debug_user')]
    public function debugUser(): Response
    {
        $token = $this->tokenStorage->getToken();
        
        if ($token) {
            $user = $token->getUser();
            var_dump($user); // Affiche les détails de l'utilisateur
        } else {
            echo "Aucun utilisateur n'est actuellement authentifié.";
        }

        // Autres actions ou retour de réponse
        return $this->render('some/index.html.twig', [
            'controller_name' => 'SomeController',
        ]);
    }}
