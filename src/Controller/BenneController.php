<?php

namespace App\Controller;

use App\Service\AvailableOptions;
use App\Entity\BonSortie;
use App\Repository\BonSortieRepository;
use App\Entity\Site;
use App\Repository\SiteRepository;
use App\Entity\Demande;
use App\Repository\DemandeRepository;
use App\Entity\Benne;
use App\Form\BenneType;
use App\Repository\BenneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/benne')]
class BenneController extends AbstractController
{
    #[IsGranted('ROLE_STOCK')]
    #[Route('/', name: 'app_benne_index', methods: ['GET'])]
    public function index(BenneRepository $benneRepository): Response
    {
        return $this->render('benne/index.html.twig', [
            'bennes' => $benneRepository->findAll(),
        ]);
    }

    #[IsGranted('ROLE_STOCK')]
    #[Route('/new', name: 'app_benne_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BenneRepository $benneRepository): Response
    {
        $benne = new Benne();
        $form = $this->createForm(BenneType::class, $benne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $benneRepository->add($benne, true);
            $this->addFlash(
                'success-bennes',
                "La benne a été enregistrée.",
            );
            return $this->redirectToRoute('app_benne_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('benne/new.html.twig', [
            'benne' => $benne,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_AFFECTATION')]
    #[Route('/affectation/demande/{id}', name: 'app_benne_affectation_demande', methods: ['GET', 'POST'])]
    public function affectation_site(Request $request, Demande $demande, DemandeRepository $demandeRepository, BenneRepository $benneRepository, BonSortieRepository $bonSortieRepository): Response
    {
        if($demande->getStatut() === AvailableOptions::getStatutSitesAffectation()["Affecter OK"]) {
            $this->addFlash(
                'notice-demandes-affectation',
                "L'affectation a déjà été validée."
            );
            return $this->redirectToRoute('app_bon_sortie_index', [], Response::HTTP_SEE_OTHER);
        }
        if($demande->getNombreBennes() === 0) {
            $this->addFlash(
                'notice-demandes-affectation',
                "Le nombre de Bennes ne peut être égale à zéro."
            );
            return $this->redirectToRoute('app_demande_affectation', [], Response::HTTP_SEE_OTHER);
        }
        $site = $demande->getSite();
        if($site->hasContrat() === false) {
            $this->addFlash(
                'notice-demandes-affectation',
                "Le site n'a pas de contrat lié."
            );
            return $this->redirectToRoute('app_demande_affectation', [], Response::HTTP_SEE_OTHER);
        }
        if($site->hasFreeBenne($demande->getNombreBennes()) === false) {
            $this->addFlash(
                'notice-demandes-affectation',
                "Le site n'a pas assez de bennes disponibles."
            );
            return $this->redirectToRoute('app_demande_affectation', [], Response::HTTP_SEE_OTHER);
        }
        $contrat = $site->getContrat($site);
        if($contrat->canStart($site) === false) {
            $this->addFlash(
                'notice-demandes-affectation',
                "Le contrat lié au site n'a pas encore commencé."
            );
            return $this->redirectToRoute('app_demande_affectation', [], Response::HTTP_SEE_OTHER);
        }
        if($contrat->IsExpired($site) === false) {
            $this->addFlash(
                'notice-demandes-affectation',
                "Le contrat a expiré."
            );
            return $this->redirectToRoute('app_demande_affectation', [], Response::HTTP_SEE_OTHER);
        }
        $criteria = array(
            "etat" => "Libre",
            "statut_workflow" => "Libre : Logistique",
        );
        $orderBy = array(
            "id" => "DESC"
        );
        $limit = $demande->getNombreBennes();
        $bennes = $benneRepository->findBy($criteria, $orderBy, $limit);
        if(count($bennes) != $limit) {
            $this->addFlash(
                'notice-demandes-affectation',
                "Il n'y a pas assez de bennes en stock."
            );
            return $this->redirectToRoute('app_demande_affectation', [], Response::HTTP_SEE_OTHER);
        }
        if(empty($bennes)) {
            $this->addFlash(
                'notice-demandes-affectation',
                "Il n'y a plus de bennes en stock."
            );
            return $this->redirectToRoute('app_demande_affectation', [], Response::HTTP_SEE_OTHER);
        }
        $bonSortie = new BonSortie();
        $bonSortie->setDemande($demande);
        $bonSortieRepository->add($bonSortie, true);
        foreach ($bennes as $benne) {
            $benne->setEtat(AvailableOptions::getEtatBenne()["En attente de validation"]); // Prev : "Libre"
            $benne->setStatutWorkflow(AvailableOptions::getworkflow()["Génération Bon de Sortie : Stock"]); // Prev : "Libre : Logistique"
            $benne->setSite($demande->getSite());
            $benne->addBonSortie($bonSortie);
            $benneRepository->add($benne, true);
        }
        $demande->setStatut(AvailableOptions::getStatutSitesAffectation()["Affecter OK"]); // Prev : "Affecter"
        $demande->setBonSortie($bonSortie);
        $demandeRepository->add($demande, true);
        $this->addFlash(
            'success-demandes-affectation',
            "Affectation réalisée. Benne(s) affectée(s) : " . count($bennes),
        );
        return $this->redirectToRoute('app_demande_affectation', [], Response::HTTP_SEE_OTHER);
    }

    #[IsGranted('ROLE_STOCK')]
    #[Route('/{id}', name: 'app_benne_show', methods: ['GET'])]
    public function show(Benne $benne): Response
    {
        return $this->render('benne/show.html.twig', [
            'benne' => $benne,
            'fromController' => 'BenneController',
        ]);
    }

    #[IsGranted('ROLE_STOCK')]
    #[Route('/{id}/edit', name: 'app_benne_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Benne $benne, BenneRepository $benneRepository): Response
    {
        if($benne->getEtat() !== AvailableOptions::getEtatBenne()["Libre"]) {
            $this->addFlash(
                'notice-bennes',
                "La Benne est en cours de process. Modifcation non permise."
            );
            return $this->redirectToRoute('app_benne_index', [], Response::HTTP_SEE_OTHER);
        }

        $form = $this->createForm(BenneType::class, $benne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $benneRepository->add($benne, true);
            $this->addFlash(
                'success-bennes',
                "La benne a été enregistrée.",
            );
            return $this->redirectToRoute('app_benne_edit', ['id' => $benne->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('benne/edit.html.twig', [
            'benne' => $benne,
            'form' => $form,
            'fromController' => 'BenneController',
        ]);
    }
}
