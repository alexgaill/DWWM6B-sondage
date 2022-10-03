<?php

namespace App\Controller;

use App\Entity\Question;
use App\Form\QuestionType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class QuestionController extends AbstractController
{
    public function __construct(
        private ManagerRegistry $manager,
    ){}

    #[Route('/questions', name: 'app_question')]
    public function index(Request $request): Response
    {
        $question = new Question;
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $om = $this->manager->getManager();
            $om->persist($question);
            $om->flush();
            return $this->redirectToRoute('app_question');
        }

        return $this->renderForm('question/index.html.twig', [
            'questions' => $this->manager->getRepository(Question::class)->findAll(),
            'form' => $form
        ]);
    }

    #[Route('/questions/{id}', name:"update_question", requirements:['id' => "\d+"], methods:['GET', 'POST'])]
    public function update(int $id, Request $request): Response
    {
        $repository = $this->manager->getRepository(Question::class);
        $question = $repository->find($id);

        if (!$question) {
            throw $this->createNotFoundException("Question non trouvée");
        }

        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($question, true);
            return $this->redirectToRoute('app_question');
        }

        return $this->renderForm('question/update.html.twig', [
            'form' => $form
        ]);
    }
}
