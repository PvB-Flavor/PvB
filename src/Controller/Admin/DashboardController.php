<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use App\Entity\Question;
use App\Entity\Research;
use App\Form\ContactType;
use App\Form\QuestionType;
use App\Form\ResearchType;
use Doctrine\Persistence\ManagerRegistry;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
 */
class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/", name="app_admin")
     */
    public function index(): Response
    {
        $email = null;
        if ($this->getUser()) $email = $this->getUser()->getUserIdentifier();

        return $this->render('admin/dashboard.html.twig', get_defined_vars());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Bureau Profiel')
            ->disableDarkMode();
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
            MenuItem::linkToRoute('Vragen', 'fa-solid fa-question', 'app_admin_questions'),
            MenuItem::linkToRoute('Contact', 'fa-solid fa-address-book', 'app_admin_contacts'),
            MenuItem::linkToRoute('Onderzoeken', 'fa-solid fa-book', 'app_admin_researches'),
            MenuItem::linkToRoute('Naar site', 'fa-solid fa-arrow-right-from-bracket', 'app_home')
        ];
    }

    /**
     * @Route("/contact", name="app_admin_contacts",
     *     defaults={"action": "all"}
     * )
     *
     * @Route("/contact/{id}", name="app_admin_contacts_view", requirements={"id"="\d+"},
     *     defaults={"action": "view"}
     * )
     *
     * @Route("/contact/delete/{id}", name="app_admin_contacts_delete", methods={"POST"},
     *     requirements={"id"="\d+"},
     *     defaults={"action": "delete"}
     * )
     *
     * @ParamConverter("Contact", isOptional="true", class="App\Entity\Contact")
     *
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @param $action
     * @param Contact|null $contact
     * @return Response|Exception
     */
    public function contacts(Request $request, ManagerRegistry $doctrine, $action = null, ?Contact $contact = null): ?Response
    {
        if ($action === 'all' || $action === null) {
            $contacts = $doctrine->getManager()->getRepository(Contact::class)->findAll();
            return $this->render('admin/contacts.html.twig', get_defined_vars());
        } else if ($action === 'view') {
            if (!$contact) return $this->redirectToRoute('app_admin_contacts');
            return $this->render('admin/contactsView.html.twig', get_defined_vars());
        } else if ($action === 'delete') {
            $doctrine->getManager()->remove($contact);
            $doctrine->getManager()->flush();
            return new Response('success');
        }

        throw new Exception('Target not found.');
    }

    /**
     * @Route("/onderzoeken", name="app_admin_researches",
     *     defaults={"action": "all"}
     * )
     *
     * @Route("/onderzoeken/nieuw", name="app_admin_researches_new",
     *     defaults={"action": "new"}
     * )
     *
     * @Route("/onderzoeken/{id}", name="app_admin_researches_edit", requirements={"id"="\d+"},
     *     defaults={"action": "edit"}
     * )
     *
     * @Route("/onderzoeken/delete/{id}", name="app_admin_research_delete", methods={"POST"},
     *     requirements={"id"="\d+"},
     *     defaults={"action": "delete"}
     * )
     *
     * @ParamConverter("Research", isOptional="true", class="App\Entity\Research")
     *
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @param SluggerInterface $slugger
     * @param null $action
     * @param Research|null $research
     * @return Response|Exception
     */
    public function researches(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger, $action = null, ?Research $research = null): ?Response
    {
        if ($action === 'all' || $action === null) {
            $researches = $doctrine->getManager()->getRepository(Research::class)->findAll();
            return $this->render('admin/researches.html.twig', get_defined_vars());
        } else if ($action === 'edit' || $action === 'new') {
            if (!$research) {
                if ($action === 'edit') return $this->redirectToRoute('app_admin_researches');

                $research = new Research();
            }

            $form = $this->createForm(ResearchType::class, $research);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $imageFile = $form->get('image')->getData();
                $companyImageFile = $form->get('companyImage')->getData();

                if ($imageFile) {
                    $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                    try {
                        $imageFile->move(
                            $this->getParameter('kernel.project_dir').'/public/uploads',
                            $newFilename
                        );
                    } catch (FileException $e) {
                        throw new FileException('Failed to upload image.');
                    }

                    $research->setImage($newFilename);
                } else {
                    $research->setImage('placeholder.jpg');
                }

                if ($companyImageFile) {
                    $originalFilename = pathinfo($companyImageFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$companyImageFile->guessExtension();

                    try {
                        $companyImageFile->move(
                            $this->getParameter('kernel.project_dir').'/public/uploads',
                            $newFilename
                        );
                    } catch (FileException $e) {
                        throw new FileException('Failed to upload image.');
                    }

                    $research->setCompanyImage($newFilename);
                } else {
                    $research->setCompanyImage('placeholder.jpg');
                }

                $doctrine->getManager()->persist($research);
                $doctrine->getManager()->flush();

                return $this->redirectToRoute('app_admin_researches');
            }

            return $this->renderForm('admin/researchForm.html.twig', get_defined_vars());
        } else if ($action === 'delete') {
            $doctrine->getManager()->remove($research);
            $doctrine->getManager()->flush();
            return new Response('success');
        }

        throw new Exception('Target not found.');
    }

    /**
     * @Route("/vragen", name="app_admin_questions",
     *     defaults={"action": "all"}
     * )
     *
     * @Route("/vragen/nieuw", name="app_admin_question_new",
     *     defaults={"action": "new"}
     * )
     *
     * @Route("/vragen/{id}", name="app_admin_question_edit", requirements={"id"="\d+"},
     *     defaults={"action": "edit"}
     * )
     *
     * @Route("/vragen/delete/{id}", name="app_admin_question_delete", methods={"POST"},
     *     requirements={"id"="\d+"},
     *     defaults={"action": "delete"}
     * )
     *
     * @ParamConverter("Question", isOptional="true", class="App\Entity\Question")
     *
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @param null $action
     * @param Question|null $question
     * @return Response|Exception
     */
    public function questions(Request $request, ManagerRegistry $doctrine, $action = null, ?Question $question = null): ?Response
    {
        if ($action === 'all' || $action === null) {

            $questions = $doctrine->getManager()->getRepository(Question::class)->findAll();
            return $this->render('admin/questions.html.twig', get_defined_vars());

        } else if ($action === 'edit' || $action === 'new') {

            if (!$question) {
                if ($action === 'edit') return $this->redirectToRoute('app_admin_questions');
                $question = new Question();
            }

            $form = $this->createForm(QuestionType::class, $question);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $options = $form->get('options')->getData();
                $options = explode(",", $options);

                $question->setOptions($options);

                $doctrine->getManager()->persist($question);
                $doctrine->getManager()->flush();

                return $this->redirectToRoute('app_admin_questions');
            }

            return $this->renderForm('admin/questionForm.html.twig', get_defined_vars());

        } else if ($action === 'delete') {

            $doctrine->getManager()->remove($question);
            $doctrine->getManager()->flush();
            return new Response('success');

        }

        throw new Exception('Target not found.');
    }
}
