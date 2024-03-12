<?php

namespace App\Controller;

use App\Entity\Site;
use App\Form\SiteType;
use App\Form\SiteEditType;
use App\Repository\SiteRepository;
use App\Repository\BenneRepository;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_COMMERCIAL')]
#[Route('/site')]
class SiteController extends AbstractController
{
    #[Route('/', name: 'app_site_index', methods: ['GET'])]
    public function index(SiteRepository $siteRepository): Response
    {
        return $this->render('site/index.html.twig', [
            'sites' => $siteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_site_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SiteRepository $siteRepository, BenneRepository $benneRepository, ClientRepository $clientRepository): Response
    {
        $site = new Site();
        $form = $this->createForm(SiteType::class, $site);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($site->getNombreBennes() === 0) {
                $this->addFlash(
                    'notice-site',
                    "Le nombre de Bennes ne peut être égale à zéro."
                );
                return $this->renderForm('site/new.html.twig', [
                    'site' => $site,
                    'form' => $form,
                ]);
            }
            $siteRepository->add($site, true);
            $this->addFlash(
                'success-site',
                "Le site a été enregistré."
            );
            return $this->redirectToRoute('app_site_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('site/new.html.twig', [
            'site' => $site,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_site_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Site $site, SiteRepository $siteRepository, ClientRepository $clientRepository): Response
    {
        $clientSite = $site->getClient();
        $criteria = array(
            'id' => $clientSite->getId()
        );
        $orderBy = array(
            'id' => 'DESC'
        );
        $client = $clientRepository->findOneBy($criteria, $orderBy);
        $form = $this->createForm(SiteEditType::class, $site, array('client' => $client));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($site->getNombreBennes() === 0) {
                $this->addFlash(
                    'notice-site',
                    "Le nombre de Bennes ne peut être égale à zéro."
                );
                return $this->renderForm('site/edit.html.twig', [
                    'site' => $site,
                    'form' => $form,
                ]);
            }
            $siteRepository->add($site, true);
            $this->addFlash(
                'success-site',
                "Le site a été enregistré."
            );
            return $this->redirectToRoute('app_site_edit', ['id' => $site->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('site/edit.html.twig', [
            'site' => $site,
            'form' => $form,
            'fromController' => 'SiteController',
        ]);
    }
}
