<?php

namespace App\Controller;

use App\Service\AvailableOptions;
use App\Entity\Demande;
use App\Form\DemandeType;
use App\Repository\DemandeRepository;
use App\Repository\SiteRepository;
use App\Repository\BenneRepository;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_AFFECTATION')]
#[Route('/demande')]
class DemandeController extends AbstractController
{
    #[Route('/', name: 'app_demande_index', methods: ['GET'])]
    public function index(DemandeRepository $demandeRepository): Response
    {
        $criteria = [];
        $orderBy = array(
            "id" => "DESC"
        );
        $demandes = $demandeRepository->findBy($criteria, $orderBy);
        return $this->render('demande/index.html.twig', [
            'demandes' => $demandes,
        ]);
    }

    #[Route('/new', name: 'app_demande_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DemandeRepository $demandeRepository): Response
    {
        $demande = new Demande();
        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($demande->getNombreBennes() === 0) {
                $this->addFlash(
                    'notice-demandes',
                    "Le nombre de Bennes ne peut être égale à zéro."
                );
                return $this->renderForm('demande/new.html.twig', [
                    'demande' => $demande,
                    'form' => $form,
                ]);
            }
            $demandeRepository->add($demande, true);
            $this->addFlash(
                'success-demandes',
                "La demande a été enregistrée."
            );
            return $this->redirectToRoute('app_demande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('demande/new.html.twig', [
            'demande' => $demande,
            'form' => $form,
        ]);
    }

    #[Route('/affectation', name: 'app_demande_affectation', methods: ['GET'])]
    public function affectation(DemandeRepository $demandeRepository): Response
    {
        $criteria = array(
            "statut" => "Affecter", // Only demande to process by logistic profile.
        );
        $orderBy = array(
            "id" => "ASC" // To smallest to tallest.
        );
        return $this->render('demande/affectation.html.twig', [
            'demandes' => $demandeRepository->findBy($criteria, $orderBy),
        ]);
    }

    #[Route('/{id}', name: 'app_demande_show', methods: ['GET'])]
    public function show(Demande $demande): Response
    {
        return $this->render('demande/show.html.twig', [
            'demande' => $demande,
            'fromController' => 'DemandeController',
        ]);
    }

    #[Route('/{id}/edit', name: 'app_demande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Demande $demande, DemandeRepository $demandeRepository): Response
    {
        if($demande->getStatut() === AvailableOptions::getStatutDemandesAffectation()["Affecter OK"]) {
            $this->addFlash(
                'notice-demandes',
                "L'affectation de cette demande a déjà été validée. Vous ne pouvez plus supprimer cette demande."
            );
            return $this->redirectToRoute('app_demande_index', [], Response::HTTP_SEE_OTHER);
        }
        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($demande->getNombreBennes() === 0) {
                $this->addFlash(
                    'notice-demandes',
                    "Le nombre de Bennes ne peut être égale à zéro."
                );
                return $this->renderForm('demande/edit.html.twig', [
                    'demande' => $demande,
                    'form' => $form,
                ]);
            }
            $demandeRepository->add($demande, true);
            $this->addFlash(
                'success-demandes',
                "La demande a été enregistrée."
            );
            return $this->redirectToRoute('app_demande_edit', ['id' => $demande->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('demande/edit.html.twig', [
            'demande' => $demande,
            'form' => $form,
            'fromController' => 'DemandeController',
        ]);
    }

    #[Route('/{id}', name: 'app_demande_delete', methods: ['POST'])]
    public function delete(Request $request, Demande $demande, DemandeRepository $demandeRepository): Response
    {
        if($demande->getStatut() === AvailableOptions::getStatutDemandesAffectation()["Affecter OK"]) {
            $this->addFlash(
                'notice-demandes',
                "L'affectation de cette demande a déjà été validée. Vous ne pouvez plus supprimer cette demande."
            );
            return $this->redirectToRoute('app_demande_index', [], Response::HTTP_SEE_OTHER);
        }
        if ($this->isCsrfTokenValid('delete'.$demande->getId(), $request->request->get('_token'))) {
            $demandeRepository->remove($demande, true);
        }

        return $this->redirectToRoute('app_demande_index', [], Response::HTTP_SEE_OTHER);
    }
}
