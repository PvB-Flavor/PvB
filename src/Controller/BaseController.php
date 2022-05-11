<?php

namespace App\Controller;

use App\Entity\Question;
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
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $email = null;
        if ($this->getUser()) $email = $this->getUser()->getUserIdentifier();

        $questions = $doctrine->getRepository(Question::class)->findAll();

        $maxPageSize = 10;

        $pages = [];

        $currentPage = 0;

        foreach ( $questions as $question ) {
            if (!array_key_exists($currentPage, $pages)) $pages[$currentPage] = [];
            array_push($pages[$currentPage], $question);

            if (count($pages[$currentPage]) >= $maxPageSize) $currentPage++;
        }

        return $this->render('base/index.html.twig', get_defined_vars());
    }

    /**
     * @Route("/contact", name="app_contact")
     *
     * @return Response
     */
    public function contact(): Response
    {
        $email = null;
        if ($this->getUser()) $email = $this->getUser()->getUserIdentifier();

        return $this->render('base/contact.html.twig', get_defined_vars());
    }

    /**
     * @Route("/respondent", name="app_respondent")
     *
     * @return Response
     */
    public function respondent(): Response
    {
        $email = null;
        if ($this->getUser()) $email = $this->getUser()->getUserIdentifier();

        return $this->render('base/respondent.html.twig', get_defined_vars());
    }

    /**
     * @Route("/company", name="app_company")
     *
     * @return Response
     */
    public function company(): Response
    {
        $email = null;
        if ($this->getUser()) $email = $this->getUser()->getUserIdentifier();

        return $this->render('base/company.html.twig', get_defined_vars());
    }
}
