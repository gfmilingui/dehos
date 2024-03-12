<?php

namespace App\Controller;

use App\Entity\ClientCategorie;
use App\Form\ClientCategorieType;
use App\Repository\ClientCategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_COMMERCIAL')]
#[Route('/client/categorie')]
class ClientCategorieController extends AbstractController
{
    #[Route('/', name: 'app_client_categorie_index', methods: ['GET'])]
    public function index(ClientCategorieRepository $clientCategorieRepository): Response
    {
        return $this->render('client_categorie/index.html.twig', [
            'client_categories' => $clientCategorieRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_client_categorie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ClientCategorieRepository $clientCategorieRepository): Response
    {
        $clientCategorie = new ClientCategorie();
        $form = $this->createForm(ClientCategorieType::class, $clientCategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clientCategorieRepository->add($clientCategorie, true);

            return $this->redirectToRoute('app_client_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client_categorie/new.html.twig', [
            'client_categorie' => $clientCategorie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_client_categorie_show', methods: ['GET'])]
    public function show(ClientCategorie $clientCategorie): Response
    {
        return $this->render('client_categorie/show.html.twig', [
            'client_categorie' => $clientCategorie,
            'fromController' => 'ClientCategorieController',
        ]);
    }

    #[Route('/{id}/edit', name: 'app_client_categorie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ClientCategorie $clientCategorie, ClientCategorieRepository $clientCategorieRepository): Response
    {
        $form = $this->createForm(ClientCategorieType::class, $clientCategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clientCategorieRepository->add($clientCategorie, true);

            return $this->redirectToRoute('app_client_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client_categorie/edit.html.twig', [
            'client_categorie' => $clientCategorie,
            'form' => $form,
            'fromController' => 'ClientCategorieController',
        ]);
    }
}
