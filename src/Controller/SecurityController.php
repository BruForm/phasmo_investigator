<?php

namespace App\Controller;

use App\Repository\PlayerRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
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
        if ($error) {
            $this->addFlash(
                'error',
                'Les informations saisies sont incorrectes ! Connexion impossible !'
            );
        }
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @param Request $request
     * @param UserPasswordHasherInterface $passwordHasher
     * @param PlayerRepository $playerRepository
     * @param UserRepository $userRepository
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    #[Route(path: '/delete_account', name: 'app_delete_account')]
    public function deleteAccount(
        Request                     $request,
        UserPasswordHasherInterface $passwordHasher,
        PlayerRepository            $playerRepository,
        UserRepository              $userRepository,
        EntityManagerInterface      $entityManager,
    ): Response
    {
        $inputUser = $request->request->get('email');
        $inputPsw = $request->request->get('password');
        if ($inputUser) {
            if ($inputUser === $this->getUser()->getUserIdentifier()) {
                if ($inputPsw) {
                    $pswIsOK = $passwordHasher->isPasswordValid($this->getUser(), $inputPsw);
                    if ($pswIsOK) {
                        $user = $userRepository->findOneBy(['email' => $inputUser]);
                        // Update Player
                        $player = $playerRepository->findOneBy(['nickname' => $user->getNickname()]);
                        $player->setFirstname('');
                        $player->setLastname('');
                        $entityManager->persist($player);
                        $entityManager->flush();
                        // Delete User
                        $entityManager->remove($user);
                        $entityManager->flush();
                        $this->container->get('security.token_storage')->setToken(null);
                        $this->addFlash('success', 'Vos données personnelles ont été supprimées.');
                        return $this->redirectToRoute('app_home');
                    } else {
                        $this->addFlash(
                            'error',
                            "Les informations saisies sont incorrectes ! Impossible de supprimer ce profil !"
                        );
                    }
                }
            } else {
                $this->addFlash('error', "L'e-mail saisi est incorrect !");
            }
        }
        return $this->render('security/login.html.twig', [
            'last_username' => $this->getUser()->getUserIdentifier(),
        ]);
    }
}
