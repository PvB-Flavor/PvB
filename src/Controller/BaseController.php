<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     *
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('base/index.html.twig', get_defined_vars());
    }

    /**
     * @Route("/inschrijven", name="app_register")
     *
     * @return Response
     */
    public function register(): Response
    {
        return $this->render('base/register.html.twig', get_defined_vars());
    }

    /**
     * @Route("/contact", name="app_contact")
     *
     * @return Response
     */
    public function contact(): Response
    {
        return $this->render('base/contact.html.twig', get_defined_vars());
    }
}
