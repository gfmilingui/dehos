<?php

namespace App\Controller;

use App\Entity\Contrat;
use App\Form\ContratType;
use App\Form\ContratEditType;
use App\Repository\ContratRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_COMMERCIAL')]
#[Route('/contrat')]
class ContratController extends AbstractController
{
    #[Route('/', name: 'app_contrat_index', methods: ['GET'])]
    public function index(ContratRepository $contratRepository): Response
    {
        return $this->render('contrat/index.html.twig', [
            'contrats' => $contratRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_contrat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ContratRepository $contratRepository): Response
    {
        $contrat = new Contrat();
        $form = $this->createForm(ContratType::class, $contrat);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($contrat->getDateDebut() > $contrat->getDateFin()){
                $this->addFlash(
                    'notice-contrats',
                    "La date de début du contrat ne peut pas être supérieure à la date de fin du contrat."
                );
                return $this->renderForm('contrat/new.html.twig', [
                    'contrat' => $contrat,
                    'form' => $form,
                ]);
            }
            if($contrat->getDateDebut()->format('d-m-Y') == $contrat->getDateFin()->format('d-m-Y')){
                $this->addFlash(
                    'notice-contrats',
                    "La date de début du contrat ne peut pas être égale à la date de fin du contrat."
                );
                return $this->renderForm('contrat/new.html.twig', [
                    'contrat' => $contrat,
                    'form' => $form,
                ]);
            }
            $contratRepository->add($contrat, true);
            $this->addFlash(
                'success-contrats',
                "Le Contrat a été enregistré."
            );
            return $this->redirectToRoute('app_contrat_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('contrat/new.html.twig', [
            'contrat' => $contrat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_contrat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Contrat $contrat, ContratRepository $contratRepository): Response
    {
        $form = $this->createForm(ContratEditType::class, $contrat);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($contrat->getDateDebut() > $contrat->getDateFin()){
                $this->addFlash(
                    'notice-contrats',
                    "La date de début du contrat ne peut pas être supérieure à la date de fin du contrat."
                );
                return $this->renderForm('contrat/new.html.twig', [
                    'contrat' => $contrat,
                    'form' => $form,
                ]);
            }
            if($contrat->getDateDebut()->format('d-m-Y') == $contrat->getDateFin()->format('d-m-Y')){
                $this->addFlash(
                    'notice-contrats',
                    "La date de début du contrat ne peut pas être égale à la date de fin du contrat."
                );
                return $this->renderForm('contrat/new.html.twig', [
                    'contrat' => $contrat,
                    'form' => $form,
                ]);
            }
            $contratRepository->add($contrat, true);
            $this->addFlash(
                'success-contrats',
                "Le Contrat a été enregistrée."
            );
            return $this->redirectToRoute('app_contrat_edit', ['id' => $contrat->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('contrat/edit.html.twig', [
            'contrat' => $contrat,
            'form' => $form,
            'fromController' => 'ContratController',
        ]);
    }
}
