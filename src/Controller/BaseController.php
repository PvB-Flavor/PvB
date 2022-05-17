<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Question;
use App\Entity\Research;
use App\Form\ContactType;
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
        $researches = $doctrine->getRepository(Research::class)->findAll();

        $maxPageSize = 10;
        $pages = [];
        $currentPage = 0;

        foreach ( $questions as $question ) {
            if (!array_key_exists($currentPage, $pages)) $pages[$currentPage] = [];
            array_push($pages[$currentPage], $question);

            if (count($pages[$currentPage]) >= $maxPageSize) $currentPage++;
        }

        $researches = array_slice($researches, 0, 10);

        return $this->render('base/index.html.twig', get_defined_vars());
    }

    /**
     * @Route("/onderzoeken", name="app_researches")
     *
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    public function researches(ManagerRegistry $doctrine): Response
    {
        $email = null;
        if ($this->getUser()) $email = $this->getUser()->getUserIdentifier();

        $researches = $doctrine->getRepository(Research::class)->findAll();
        $researchesOngoing = [];
        $researchesDone = [];

        foreach ($researches as $research) ($research->getOngoing() === true) ? $researchesOngoing[] = $research : $researchesDone[] = $research;

        return $this->render('base/researches.html.twig', get_defined_vars());
    }

    /**
     * @Route("/respondenten", name="app_respondent")
     *
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    public function respondent(ManagerRegistry $doctrine): Response
    {
        $email = null;
        if ($this->getUser()) $email = $this->getUser()->getUserIdentifier();

        return $this->render('base/respondent.html.twig', get_defined_vars());
    }

    /**
     * @Route("/contact", name="app_contact")
     *
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    public function contact(Request $request, ManagerRegistry $doctrine): Response
    {
        $email = null;
        if ($this->getUser()) $email = $this->getUser()->getUserIdentifier();

        $contactEntry = new Contact();

        $form = $this->createForm(ContactType::class, $contactEntry);
        $form->handleRequest($request);

        $success = $request->get('success');

        if ($form->isSubmitted() && $form->isValid()) {
            $contactEntry = $form->getData();

            $doctrine->getManager()->persist($contactEntry);
            $doctrine->getManager()->flush();

            $formSent = true;

            return $this->redirectToRoute('app_contact', ['success' => true]);
        }

        return $this->renderForm('base/contact.html.twig', get_defined_vars());
    }
}
