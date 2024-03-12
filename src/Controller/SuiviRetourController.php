<?php

namespace App\Controller;

use App\Service\AvailableOptions;
use App\Entity\Traitement;
use App\Entity\Benne;
use App\Entity\BonSortie;
use App\Entity\SuiviRetour;
use App\Form\SuiviRetourType;
use App\Repository\SuiviRetourRepository;
use App\Repository\BonSortieRepository;
use App\Repository\BenneRepository;
use App\Repository\TraitementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_SUIVI_RETOUR')]
#[Route('/suivi/retour')]
class SuiviRetourController extends AbstractController
{   
    #[Route('/', name: 'app_suivi_retour_index', methods: ['GET'])]
    public function index(SuiviRetourRepository $suiviRetourRepository): Response
    {
        return $this->render('suivi_retour/index.html.twig', [
            'suivi_retours' => $suiviRetourRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_suivi_retour_show', methods: ['GET'])]
    public function show(SuiviRetour $suiviRetour): Response
    {
        return $this->render('suivi_retour/show.html.twig', [
            'suivi_retour' => $suiviRetour,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_suivi_retour_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SuiviRetour $suiviRetour, SuiviRetourRepository $suiviRetourRepository): Response
    {
        if($suiviRetour->getStatut() === AvailableOptions::getStatutSuiviRetour()["Validé"]) {
            $this->addFlash(
                'notice-suivisretours',
                'Le Suivi Retour a déjà été validé. Action non permise.'
            );
            return $this->redirectToRoute('app_suivi_retour_index', [], Response::HTTP_SEE_OTHER);
        }
        $form = $this->createForm(SuiviRetourType::class, $suiviRetour);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $suiviRetourRepository->add($suiviRetour, true);
            $this->addFlash(
                'success-suivisretours',
                'Le Suivi retour a été enregistré.'
            );
            return $this->redirectToRoute('app_suivi_retour_edit', ['id' => $suiviRetour->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('suivi_retour/edit.html.twig', [
            'suivi_retour' => $suiviRetour,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/valider', name: 'app_suivi_retour_valider', methods: ['GET', 'POST'])]
    public function suivi_retour_valider(Request $request, SuiviRetour $suiviRetour, SuiviRetourRepository $suiviRetourRepository, TraitementRepository $traitementRepository): Response
    {
        if($suiviRetour->getStatut() === AvailableOptions::getStatutSuiviRetour()["Validé"]) {
            $this->addFlash(
                'notice-suivisretours',
                'Le Suivi Retour a déjà été validé. Action non permise.'
            );
            return $this->redirectToRoute('app_suivi_retour_index', [], Response::HTTP_SEE_OTHER);
        }
        if(empty($suiviRetour->getPeseeAgent()) || empty($suiviRetour->getPeseeClient()) || empty($suiviRetour->getDateRetourBenne()))
        {
            $this->addFlash(
                'notice-suivisretours',
                'Le Suivi Retour ne peut être validé. Veuillez remplir les informations du Suivi Retour.'
            );
            return $this->redirectToRoute('app_suivi_retour_index', [], Response::HTTP_SEE_OTHER);
        }
        // Bon de Sortie
        $bonSortie = $suiviRetour->getBonSortie();
        // Suivi Retour :: Benne
        $suiviRetour->getBenne()->setEtat(AvailableOptions::getEtatBenne()["Suivi Retour Validé"]);
        $suiviRetour->getBenne()->setStatutWorkflow(AvailableOptions::getworkflow()["Suivi Retour Validé : Suivi Retours"]);
        // Suivi Retour :: Statut
        $suiviRetour->setStatut(AvailableOptions::getStatutSuiviRetour()["Validé"]);
        $suiviRetourRepository->add($suiviRetour, true);
        // Traitement
        $traitement = new Traitement();
        $traitement->setBonSortie($bonSortie);
        $traitement->setBenne($suiviRetour->getBenne());
        $traitementRepository->add($traitement, true);
        // Return to view
        $this->addFlash(
            'success-suivisretours',
            'Le Suivi retour a été validé.'
        );
        return $this->redirectToRoute('app_suivi_retour_index', [], Response::HTTP_SEE_OTHER);
    }
}
