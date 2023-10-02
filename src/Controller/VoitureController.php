<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Repository\VoitureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/mes-voitures')]
class VoitureController extends AbstractController
{
    #[Route('/', name: 'app_voiture')]
    public function index(VoitureRepository $voitureRepository): Response
    {
       // $voiture=$voitureRepository->findBy(["user"=>$this->getUser()]);

        return $this->render('voiture/index.html.twig', [
           // 'voitures' => $voitureRepository->findAll(),
            'voitures'=>$this->getUser()->getVoitures(),
        ]);
    }
    #[Route('/{id}', name: 'app_voiture_show', methods: ['GET'])]
    public function show(Voiture $voiture): Response
    {
       // $this->denyAccessUnlessGranted();//je refuse l'acce sauf si tu est autorise avec tel ou tel role
        if ($voiture->getUser()!==$this->getUser())//verfie le propriete et utilistauer connecter et si ca lui appartien pas ca met erreur
        {
            throw $this->createNotFoundException();
        }
        return $this->render('voiture/show.html.twig', [
            'voiture' => $voiture,
        ]);
    }
}
