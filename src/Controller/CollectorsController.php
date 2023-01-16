<?php

namespace App\Controller;

use App\Entity\Collectors;
use App\Form\CollectorsType;
use App\Repository\CollectorsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/collectors')]
class CollectorsController extends AbstractController
{
    #[Route('/', name: 'app_collectors_index', methods: ['GET'])]
    public function index(CollectorsRepository $collectorsRepository): Response
    {
        return $this->render('collectors/index.html.twig', [
            'collectors' => $collectorsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_collectors_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CollectorsRepository $collectorsRepository): Response
    {
        $collector = new Collectors();
        $form = $this->createForm(CollectorsType::class, $collector);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $collectorsRepository->save($collector, true);

            return $this->redirectToRoute('app_collectors_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('collectors/new.html.twig', [
            'collector' => $collector,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_collectors_show', methods: ['GET'])]
    public function show(Collectors $collector): Response
    {
        return $this->render('collectors/show.html.twig', [
            'collector' => $collector,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_collectors_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Collectors $collector, CollectorsRepository $collectorsRepository): Response
    {
        $form = $this->createForm(CollectorsType::class, $collector);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $collectorsRepository->save($collector, true);

            return $this->redirectToRoute('app_collectors_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('collectors/edit.html.twig', [
            'collector' => $collector,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_collectors_delete', methods: ['POST'])]
    public function delete(Request $request, Collectors $collector, CollectorsRepository $collectorsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$collector->getId(), $request->request->get('_token'))) {
            $collectorsRepository->remove($collector, true);
        }

        return $this->redirectToRoute('app_collectors_index', [], Response::HTTP_SEE_OTHER);
    }
}
