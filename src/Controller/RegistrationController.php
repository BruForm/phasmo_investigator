<?php

namespace App\Controller;

use App\Entity\Player;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request                     $request,
        UserPasswordHasherInterface $userPasswordHasher,
        UserAuthenticatorInterface  $userAuthenticator,
        LoginFormAuthenticator      $authenticator,
        EntityManagerInterface      $entityManager,
        ValidatorInterface          $validator,
    ): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            // Create the player with user data
            $player = new Player();
            $player->setLastname($user->getLastname());
            $player->setFirstname($user->getFirstname());
            $player->setNickname($user->getNickname());
            $player->setPassword($user->getPassword());
            $player->setNbInvestig(0);
            $player->setNbSuccess(0);
            $entityManager->persist($player);
            $entityManager->flush();

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request,
            );
        } else {
            if ($validator->validate($user)->count() > 0) {
                foreach ($validator->validate($user) as $i => $test){
                    $this->addFlash(
                        'error',
                        $validator->validate($user)->get($i)->getMessage()
                    );
                }
            } else {
                if ($form->get('plainPassword')->getData() && strlen($form->get('plainPassword')->getData()) < 6) {
                    $this->addFlash(
                        'error',
                        'Le mot de passe doit contenir au moins 6 caractères!'
                    );
                }
            }
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
