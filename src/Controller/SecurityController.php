<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
//         if ($this->getUser()) {
//             return $this->redirectToRoute('target_path');
//         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        $errorMsg = '';
        if ($error) {
            $errorMsg = 'Les informations saisies sont incorrectes ! Connexion impossible !';
        }
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $errorMsg]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


    #[Route(path: '/delete_account', name: 'app_delete_account')]
    public function deleteAccount(
        Request                     $request,
        UserPasswordHasherInterface $passwordHasher,
        AuthenticationUtils         $authenticationUtils,
    ): Response
    {
        $inputUser = $request->request->get('email');
        $inputPsw = $request->request->get('password');
        $errorMsg = '';
        if ($inputUser === $this->getUser()->getUserIdentifier()) {
            if ($inputPsw) {
                $pswIsOK = $passwordHasher->isPasswordValid($this->getUser(), $inputPsw);
                if ($pswIsOK) {
                    // delete User and update Player
                } else {
                    $errorMsg = 'Les informations saisies sont incorrectes ! Impossible de supprimer ce profil !';
                }
            }
        }

        return $this->render('security/login.html.twig', ['last_username' => $authenticationUtils->getLastUsername(), 'error' => $errorMsg]);
    }
}
