<?php

namespace App\Controller;

use Symfony\Component\Uid\Uuid;
use App\Service\AvailableOptions;
use App\Entity\Benne;
use App\Entity\BonSortie;
use App\Entity\SuiviRetour;
use App\Entity\Traitement;
use App\Form\BonSortieType;
use App\Repository\SuiviRetourRepository;
use App\Repository\BonSortieRepository;
use App\Repository\BenneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_STOCK')]
#[Route('/bon-sortie')]
class BonSortieController extends AbstractController
{
    #[Route('/', name: 'app_bon_sortie_index', methods: ['GET'])]
    public function index(BonSortieRepository $bonSortieRepository): Response
    {
        return $this->render('bon_sortie/index.html.twig', [
            'bon_sorties' => $bonSortieRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_bon_sortie_show', methods: ['GET'])]
    public function show(BonSortie $bonSortie): Response
    {
        return $this->render('bon_sortie/show.html.twig', [
            'bon_sortie' => $bonSortie,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_bon_sortie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BonSortie $bonSortie, BonSortieRepository $bonSortieRepository): Response
    {
        if($bonSortie->getStatut() === AvailableOptions::getStatutBonSortie()["Validé"]) {
            $this->addFlash(
                'notice-bonsorties',
                'Le Bon de Sortie a déjà été validé. Action non permise.'
            );
            return $this->redirectToRoute('app_bon_sortie_index', [], Response::HTTP_SEE_OTHER);
        }
        $form = $this->createForm(BonSortieType::class, $bonSortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bonSortieRepository->add($bonSortie, true);
            $this->addFlash(
                'success-bonsorties',
                'Le Bon de Sortie a été enregistré.'
            );
            return $this->redirectToRoute('app_bon_sortie_edit', ['id' => $bonSortie->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bon_sortie/edit.html.twig', [
            'bon_sortie' => $bonSortie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/valider', name: 'app_bon_sortie_valider', methods: ['GET', 'POST'])]
    public function bon_sortie_valider(Request $request, BonSortie $bonSortie, BonSortieRepository $bonSortieRepository, BenneRepository $benneRepository, SuiviRetourRepository $suiviRetourRepository): Response
    {
        if($bonSortie->getStatut() === AvailableOptions::getStatutBonSortie()["Validé"]) {
            $this->addFlash(
                'notice-bonsorties',
                'Le Bon de Sortie a déjà été validé. Action non permise.'
            );
            return $this->redirectToRoute('app_bon_sortie_index', [], Response::HTTP_SEE_OTHER);
        }
        if(empty($bonSortie->getDateSortie()) || empty($bonSortie->getNomFourgonChauffeur()) /*|| empty($bonSortie->getReference())*/)
        {
            $this->addFlash(
                'notice-bonsorties',
                'Le Bon de Sortie ne peut être validé. Veuillez remplir les informations du Bon de Sortie.'
            );
            return $this->redirectToRoute('app_bon_sortie_index', [], Response::HTTP_SEE_OTHER);
        }

        $bennes = $bonSortie->getBennes();
        foreach ($bennes as $benne) {
            // Benne
            $benne->setEtat(AvailableOptions::getEtatBenne()["Bon de sortie Validé"]);
            $benne->setStatutWorkflow(AvailableOptions::getworkflow()["Bon de sortie Validé : Stock"]);
            $benneRepository->add($benne, true);
            // Suivi Retour
            $suiviRetour = new SuiviRetour();
            $suiviRetour->setBonSortie($bonSortie);
            $suiviRetour->setBenne($benne);
            $suiviRetourRepository->add($suiviRetour, true);
        }
        // Bon de Sortie
        $bonSortie->addSuivisRetour($suiviRetour);
        $bonSortie->setStatut(AvailableOptions::getStatutBonSortie()["Validé"]);
        $bonSortieRepository->add($bonSortie, true);
        
        $this->addFlash(
            'success-bonsorties',
            'Le Bon de Sortie a été validé.'
        );
        return $this->redirectToRoute('app_bon_sortie_index', [], Response::HTTP_SEE_OTHER);
    }
}