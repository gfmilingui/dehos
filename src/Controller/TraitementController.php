<?php

namespace App\Controller;

use App\Service\AvailableOptions;
use App\Entity\Benne;
use App\Entity\BonSortie;
use App\Entity\Traitement;
use App\Form\TraitementType;
use App\Repository\TraitementRepository;
use App\Repository\BonSortieRepository;
use App\Repository\BenneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_TRAITEMENT')]
#[Route('/traitement')]
class TraitementController extends AbstractController
{
    #[Route('/', name: 'app_traitement_index', methods: ['GET'])]
    public function index(TraitementRepository $traitementRepository): Response
    {
        return $this->render('traitement/index.html.twig', [
            'traitements' => $traitementRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_traitement_show', methods: ['GET'])]
    public function show(Traitement $traitement): Response
    {
        return $this->render('traitement/show.html.twig', [
            'traitement' => $traitement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_traitement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Traitement $traitement, TraitementRepository $traitementRepository): Response
    {
        if($traitement->getStatut() === AvailableOptions::getStatutTraitement()["Validé"]) {
            $this->addFlash(
                'notice-traitements',
                'Le Traitement a déjà été validé. Action non permise.'
            );
            return $this->redirectToRoute('app_traitement_index', [], Response::HTTP_SEE_OTHER);
        }
        $form = $this->createForm(TraitementType::class, $traitement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $traitementRepository->add($traitement, true);
            $this->addFlash(
                'success-traitements',
                'Le Traitement a été enregistré.'
            );
            return $this->redirectToRoute('app_traitement_edit', ['id' => $traitement->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('traitement/edit.html.twig', [
            'traitement' => $traitement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/valider', name: 'app_traitement_valider', methods: ['GET', 'POST'])]
    public function traitement_valider(Request $request, Traitement $traitement, TraitementRepository $traitementRepository): Response
    {
        if($traitement->getStatut() === AvailableOptions::getStatutTraitement()["Validé"]) {
            $this->addFlash(
                'notice-traitements',
                'Le Traitement a déjà été validé. Action non permise.'
            );
            return $this->redirectToRoute('app_traitement_index', [], Response::HTTP_SEE_OTHER);
        }
       if(empty($traitement->getDateReception()) || empty($traitement->getDateMiseTraitement()) || empty($traitement->getDateFinTraitement()) || empty($traitement->getExpeditionNettoyage()) || $traitement->getExpeditionNettoyage() === "Non")
        {
            // || empty($traitement->getExpeditionRetourStock()) || $traitement->getExpeditionRetourStock() === "Non"

            $this->addFlash(
                'notice-traitements',
                'Le Traitement ne peut être validé. Veuillez remplir les informations du Traitement.'
            );
            return $this->redirectToRoute('app_traitement_index', [], Response::HTTP_SEE_OTHER);
        }
        // Traitement :: Benne
        $traitement->getBenne()->setEtat(AvailableOptions::getEtatBenne()["Traitement Validé"]);
        $traitement->getBenne()->setStatutWorkflow(AvailableOptions::getworkflow()["Traitement Validé : Traitement"]);
        // Traitement :: Statut
        $traitement->setStatut(AvailableOptions::getStatutTraitement()["Validé"]);
        // Save
        $traitementRepository->add($traitement, true);
        // Redirect to view
        $this->addFlash(
            'success-traitements',
            'Le Traitement a été validé.'
        );
        return $this->redirectToRoute('app_traitement_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/retour/stock', name: 'app_traitement_retour_stock', methods: ['GET'])]
    public function traitements_retour_stock(Request $request, Traitement $traitement, TraitementRepository $traitementRepository): Response
    {
        if($traitement->getExpeditionRetourStock() == "Oui") {
            $this->addFlash(
                'notice-traitements',
                'Le retour stock a déjà été réalisé. Action non permise.'
            );
            return $this->redirectToRoute('app_traitement_index', [], Response::HTTP_SEE_OTHER);
        }
        if ($traitement->getBenne()->getStatutWorkflow() == "Traitement Validé : Traitement" && $traitement->getExpeditionRetourStock() == "Non")
        {
            $traitement->getBenne()->setEtat(AvailableOptions::getEtatBenne()["Libre"]);
            $traitement->getBenne()->setStatutWorkflow(AvailableOptions::getworkflow()["Libre : Logistique"]);
            $traitement->getBenne()->setSite(null);
            $traitement->getBenne()->setDateLivraison(null);
            $traitement->setExpeditionRetourStock(AvailableOptions::getConstTraitement()["expedition_retour_stock_oui"]);
            $traitementRepository->add($traitement, true);
            $this->addFlash(
                'success-traitements',
                'Le retour stock a été effectué.'
            );
            return $this->redirectToRoute('app_traitement_index', [], Response::HTTP_SEE_OTHER);
        }
        else{
            $this->addFlash(
                'notice-traitements',
                'Le retour stock ne peut être réalisée.'
            );
        }
        return $this->redirectToRoute('app_traitement_index', [], Response::HTTP_SEE_OTHER);
    }
}
