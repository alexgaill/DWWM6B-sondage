<?php

namespace App\Controller;

use App\Entity\Sondage;
use App\Form\SondageType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SondageController extends AbstractController
{
    public function __construct(
        private ManagerRegistry $manager
    ){}

    #[Route('/', name: 'app_sondage')]
    public function index(Request $request): Response
    {
        $sondage = new Sondage;
        $form = $this->createForm(SondageType::class, $sondage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $om = $this->manager->getManager();
            $om->persist($sondage);
            $om->flush();
            return $this->redirectToRoute('app_sondage');
        }
        
        return $this->renderForm('sondage/index.html.twig', [
            'sondages' => $this->manager->getRepository(Sondage::class)->findAll(),
            'form' => $form
        ]);
    }

    #[Route('/sondage/{id}', name:"show_sondage", methods:['GET'], requirements:['id' => "\d+"])]
    public function show (int $id): Response
    {
        $sondage = $this->manager->getRepository(Sondage::class)->find($id);

        if (!$sondage) {
            throw $this->createNotFoundException("Sondage non trouvé");
        }

        return $this->render('sondage/show.html.twig', [
            'sondage' => $sondage
        ]);
    }
}
