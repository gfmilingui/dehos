<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_COMMERCIAL')]
#[Route('/client')]
class ClientController extends AbstractController
{
    #[Route('/', name: 'app_client_index', methods: ['GET'])]
    public function index(ClientRepository $clientRepository): Response
    {
        return $this->render('client/index.html.twig', [
            'clients' => $clientRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_client_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ClientRepository $clientRepository): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clientRepository->add($client, true);
            $this->addFlash(
                'success-clients',
                "Le client a été enregistré.",
            );
            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client/new.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/ajax', name: 'app_client_show_ajax', methods: ['GET'])]
    public function show_ajax(Client $client, ClientRepository $clientRepository): Response
    {
        $sitesCollection = $client->getSites();
        $sites = [];
        foreach ($sitesCollection as $site) {
            $tab_id = $site->getId();
            $tab_nom = $site->getNom();
            $nombre_bennes = $site->getNombreBennes();
            $nombre_bennes_affectee = $site->getNumBenneAffected();
            $nombre_bennes_libre = $site->getNumberBenneAvailabled();
            
            $sites[] = array(
                'id' => $tab_id, 
                'nom' => $tab_nom,
                'id' => $tab_id, 
                'nombre_bennes' => $nombre_bennes,
                'nombre_bennes_affectee' => $nombre_bennes_affectee,
                'nombre_bennes_libre' => $nombre_bennes_libre,
            );
        }
        $response = new Response(json_encode($sites));
        return $response;
    }

    #[Route('/{id}/edit', name: 'app_client_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Client $client, ClientRepository $clientRepository): Response
    {
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clientRepository->add($client, true);
            $this->addFlash(
                'success-clients',
                "Le client a été enregistré.",
            );
            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client/edit.html.twig', [
            'client' => $client,
            'form' => $form,
            'fromController' => 'ClientController',
        ]);
    }
}
