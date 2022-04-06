<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\User;
use App\Form\QuestionType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="app_admin")
     */
    public function index(): Response
    {
        $email = $this->getUser()->getUserIdentifier();

        return $this->render('dashboard/index.html.twig', get_defined_vars());
    }

    /**
     * @Route("/vragen", name="app_questions")
     */
    public function questions(ManagerRegistry $doctrine): Response
    {
        $questions = $doctrine->getManager()->getRepository(Question::class)->findAll();

        return $this->render('dashboard/questions.html.twig', get_defined_vars());
    }

    /**
     * @Route("/vragen/nieuw", name="app_new_question")
     *
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    public function newQuestion(Request $request, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();

        $question = new Question();

        $form = $this->createForm(QuestionType::class, $question);

        $form->handleRequest($request);
        $errors = $form->getErrors();

        if ($form->isSubmitted() && $form->isValid()) {
            $question = $form->getData();

            $em->persist($question);
            $em->flush();

            return $this->redirectToRoute('app_questions');
        }

        return $this->renderForm('dashboard/newQuestion.html.twig', get_defined_vars());
    }

    /**
     * @Route("/vragen/{id}", name="app_question")
     * @ParamConverter("question", class="App:Question")
     *
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @param Question $question
     * @return Response
     */
    public function editQuestion(Request $request, ManagerRegistry $doctrine, Question $question): Response
    {
        $em = $doctrine->getManager();

        $form = $this->createForm(QuestionType::class, $question);

        $form->handleRequest($request);
        $errors = $form->getErrors();

        if ($form->isSubmitted() && $form->isValid()) {
            $question = $form->getData();

            if ($form->getData()->getOptions()) {
                $options = [];

                $givenOptions = explode(",", $form->getData()['options']);

                foreach ($givenOptions as $givenOption) array_push($options, $givenOption);

                $question->setOptions($options);
            }

            $em->persist($question);
            $em->flush();

            return $this->redirectToRoute('app_questions');
        }

        return $this->renderForm('dashboard/newQuestion.html.twig', get_defined_vars());
    }
}
