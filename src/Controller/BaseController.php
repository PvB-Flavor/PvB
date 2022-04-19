<?php

namespace App\Controller;

use App\Form\RegisterType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/contact", name="app_contact")
     *
     * @return Response
     */
    public function contact(): Response
    {
        return $this->render('base/contact.html.twig', get_defined_vars());
    }
}
