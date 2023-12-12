<?php

namespace App\Controller;

use App\Entity\Acceuil;
use App\Form\AcceuilType;
use App\Repository\AcceuilRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class AcceuilController extends AbstractController
{
    #[Route('/', name: 'app_acceuil_index', methods: ['GET'])]
    public function index(AcceuilRepository $acceuilRepository): Response
    {
        return $this->render('acceuil/index.html.twig', [
            'acceuils' => $acceuilRepository->findAll(),
        ]);
    }
    

    #[Route('/new', name: 'app_acceuil_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $acceuil = new Acceuil();
        $form = $this->createForm(AcceuilType::class, $acceuil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($acceuil);
            $entityManager->flush();

            return $this->redirectToRoute('app_acceuil_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('acceuil/new.html.twig', [
            'acceuil' => $acceuil,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_acceuil_show', methods: ['GET'])]
    public function show(Acceuil $acceuil): Response
    {
        return $this->render('acceuil/show.html.twig', [
            'acceuil' => $acceuil,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_acceuil_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Acceuil $acceuil, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AcceuilType::class, $acceuil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_acceuil_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('acceuil/edit.html.twig', [
            'acceuil' => $acceuil,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_acceuil_delete', methods: ['POST'])]
    public function delete(Request $request, Acceuil $acceuil, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$acceuil->getId(), $request->request->get('_token'))) {
            $entityManager->remove($acceuil);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_acceuil_index', [], Response::HTTP_SEE_OTHER);
    }

}
