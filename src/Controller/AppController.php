<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_USER')]
class AppController extends AbstractController
{
    #[Route('/', name: 'app_app')]
    public function index(): Response
    {
        // usually you'll want to make sure the user is authenticated first,
        // see "Authorization" below
        // $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // Use Annotation #[IsGranted('ROLE_ADMIN')] directly in Class Controller

        // returns your User object, or null if the user is not authenticated
        // use inline documentation to tell your editor your exact User class
        /** @var \App\Entity\User $user */
        // $user = $this->getUser();

        // GOOD - use of the normal security methods
        // $hasAccess = $this->isGranted('ROLE_ADMIN');
        // $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if($this->isGranted('ROLE_MANAGER')) {
            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }
        if($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }
        if($this->isGranted('ROLE_SUPER_ADMIN')) {
            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }
        if($this->isGranted('ROLE_COMMERCIAL')) {
            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }
        if($this->isGranted('ROLE_STOCK')) {
            return $this->redirectToRoute('app_benne_index', [], Response::HTTP_SEE_OTHER);
        }
        if($this->isGranted('ROLE_AFFECTATION')) {
            return $this->redirectToRoute('app_demande_affectation', [], Response::HTTP_SEE_OTHER);
        }
        if($this->isGranted('ROLE_SUIVI_RETOUR')) {
            return $this->redirectToRoute('app_suivi_retour_index', [], Response::HTTP_SEE_OTHER);
        }
        if($this->isGranted('ROLE_TRAITEMENT')) {
            return $this->redirectToRoute('app_traitement_index', [], Response::HTTP_SEE_OTHER);
        }
        if($this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }

        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}
