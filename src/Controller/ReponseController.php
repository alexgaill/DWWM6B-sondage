<?php

namespace App\Controller;

use App\Entity\Reponse;
use App\Form\ReponseType;
use App\Repository\ReponseRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ReponseController extends AbstractController
{
    private ReponseRepository $repository;

    public function __construct(
        private ManagerRegistry $manager
    ){
        $this->repository = $manager->getRepository(Reponse::class);
    }

    #[Route('/reponses', name: 'app_reponse')]
    public function index(Request $request): Response
    {
        $reponse = new Reponse;
        $form = $this->createForm(ReponseType::class, $reponse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->save($reponse, true);
            return $this->redirectToRoute('app_reponse');
        }

        return $this->renderForm('reponse/index.html.twig', [
            'reponses' => $this->manager->getRepository(Reponse::class)->findAll(),
            'form' => $form
        ]);
    }

    #[Route('/reponse/{id}', name:'update_reponse', methods:['GET', 'POST'], requirements:['id' => "\d+"])]
    public function update(int $id, Request $request): Response
    {
        $reponse = $this->repository->find($id);

        if (!$reponse) {
            throw $this->createNotFoundException("réponse inexistante");
        }

        $form = $this->createForm(ReponseType::class, $reponse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->save($reponse, true);
            return $this->redirectToRoute('app_reponse');
        }

        return $this->renderForm('reponse/update.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/reponse/{id}/up', name:"up_reponse", methods:['GET'], requirements:['id' => "\d+"])]
    public function upVote (int $id): Response
    {
        $reponse = $this->repository->find($id);
        if (!$reponse) {
            throw $this->createNotFoundException("réponse inexistante");
        }

        $reponse->setScore($reponse->getScore() +1);

        $this->repository->save($reponse, true);

        return $this->redirectToRoute('show_sondage', ['id' => $reponse->getQuestion()->getSondage()->getId()]);
    }
}
