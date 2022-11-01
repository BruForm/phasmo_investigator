<?php

namespace App\Controller;

use App\Entity\Evidence;
use App\Form\EvidenceType;
use App\Repository\EvidenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/evidence')]
class AdminEvidenceController extends AbstractController
{
    #[Route('/', name: 'app_admin_evidence_index', methods: ['GET'])]
    public function index(EvidenceRepository $evidenceRepository): Response
    {
        return $this->render('admin_evidence/index.html.twig', [
            'evidence' => $evidenceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_evidence_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EvidenceRepository $evidenceRepository): Response
    {
        $evidence = new Evidence();
        $form = $this->createForm(EvidenceType::class, $evidence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $evidenceRepository->save($evidence, true);

            return $this->redirectToRoute('app_admin_evidence_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_evidence/new.html.twig', [
            'evidence' => $evidence,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_evidence_show', methods: ['GET'])]
    public function show(Evidence $evidence): Response
    {
        return $this->render('admin_evidence/show.html.twig', [
            'evidence' => $evidence,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_evidence_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Evidence $evidence, EvidenceRepository $evidenceRepository): Response
    {
        $form = $this->createForm(EvidenceType::class, $evidence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $evidenceRepository->save($evidence, true);

            return $this->redirectToRoute('app_admin_evidence_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_evidence/edit.html.twig', [
            'evidence' => $evidence,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_evidence_delete', methods: ['POST'])]
    public function delete(Request $request, Evidence $evidence, EvidenceRepository $evidenceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evidence->getId(), $request->request->get('_token'))) {
            $evidenceRepository->remove($evidence, true);
        }

        return $this->redirectToRoute('app_admin_evidence_index', [], Response::HTTP_SEE_OTHER);
    }
}
