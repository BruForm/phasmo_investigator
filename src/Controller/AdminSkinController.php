<?php

namespace App\Controller;

use App\Entity\Skin;
use App\Form\SkinType;
use App\Repository\SkinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/skin')]
class AdminSkinController extends AbstractController
{
    #[Route('/', name: 'app_admin_skin_index', methods: ['GET'])]
    public function index(SkinRepository $skinRepository): Response
    {
        return $this->render('admin_skin/index.html.twig', [
            'skins' => $skinRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_skin_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SkinRepository $skinRepository): Response
    {
        $skin = new Skin();
        $form = $this->createForm(SkinType::class, $skin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $skinRepository->save($skin, true);

            return $this->redirectToRoute('app_admin_skin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_skin/new.html.twig', [
            'skin' => $skin,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_skin_show', methods: ['GET'])]
    public function show(Skin $skin): Response
    {
        return $this->render('admin_skin/show.html.twig', [
            'skin' => $skin,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_skin_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Skin $skin, SkinRepository $skinRepository): Response
    {
        $form = $this->createForm(SkinType::class, $skin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $skinRepository->save($skin, true);

            return $this->redirectToRoute('app_admin_skin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_skin/edit.html.twig', [
            'skin' => $skin,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_skin_delete', methods: ['POST'])]
    public function delete(Request $request, Skin $skin, SkinRepository $skinRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$skin->getId(), $request->request->get('_token'))) {
            $skinRepository->remove($skin, true);
        }

        return $this->redirectToRoute('app_admin_skin_index', [], Response::HTTP_SEE_OTHER);
    }
}
