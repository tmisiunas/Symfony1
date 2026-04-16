<?php

namespace App\Controller;

use App\Entity\Tmp;
use App\Form\TmpType;
use App\Repository\TmpRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tmp')]
final class TmpController extends AbstractController
{
    #[Route(name: 'app_tmp_index', methods: ['GET'])]
    public function index(TmpRepository $tmpRepository): Response
    {
        return $this->render('tmp/index.html.twig', [
            'tmps' => $tmpRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_tmp_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tmp = new Tmp();
        $form = $this->createForm(TmpType::class, $tmp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tmp);
            $entityManager->flush();

            return $this->redirectToRoute('app_tmp_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tmp/new.html.twig', [
            'tmp' => $tmp,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tmp_show', methods: ['GET'])]
    public function show(Tmp $tmp): Response
    {
        return $this->render('tmp/show.html.twig', [
            'tmp' => $tmp,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tmp_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tmp $tmp, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TmpType::class, $tmp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_tmp_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tmp/edit.html.twig', [
            'tmp' => $tmp,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tmp_delete', methods: ['POST'])]
    public function delete(Request $request, Tmp $tmp, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tmp->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($tmp);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_tmp_index', [], Response::HTTP_SEE_OTHER);
    }
}
