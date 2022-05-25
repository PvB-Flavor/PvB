<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     *
     * @param AuthenticationUtils $authenticationUtils
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils, ManagerRegistry $doctrine): Response
    {
         if ($this->getUser()) {
             return $this->redirectToRoute('app_admin');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

         $dashboardEmail = $doctrine->getManager()->getRepository(User::class)->findAll()[0]->getUserIdentifier();

        return $this->render('security/login.html.twig', get_defined_vars());
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/createUser", name="app_new_user")
     *
     * @param ManagerRegistry $doctrine
     * @param UserPasswordHasherInterface $userPasswordHasher
     * @return string
     */
    public function createUserAction(ManagerRegistry $doctrine, UserPasswordHasherInterface $userPasswordHasher): string
    {
        $newUser = new User();
        $newUser->setEmail('justrom104@gmail.com');
        $newUser->setRoles(['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']);

        $newUser->setPassword(
            $userPasswordHasher->hashPassword(
                $newUser,
                "flavor"
            )
        );

        $entityManager = $doctrine->getManager();
        $entityManager->persist($newUser);
        $entityManager->flush();

        return new Response('success');
    }
}
