<?php

namespace App\Controller;

use App\Entity\Level;
use App\Form\LevelType;
use App\Repository\LevelRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/level')]
#[Security("is_granted('ROLE_ADMIN')")]
class AdminLevelController extends AbstractController
{
    #[Route('/', name: 'app_admin_level_index', methods: ['GET'])]
    public function index(LevelRepository $levelRepository): Response
    {
        return $this->render('admin_level/index.html.twig', [
            'levels' => $levelRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_level_new', methods: ['GET', 'POST'])]
    public function new(Request $request, LevelRepository $levelRepository): Response
    {
        $level = new Level();
        $form = $this->createForm(LevelType::class, $level);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $levelRepository->save($level, true);

            return $this->redirectToRoute('app_admin_level_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_level/new.html.twig', [
            'level' => $level,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_level_show', methods: ['GET'])]
    public function show(Level $level): Response
    {
        return $this->render('admin_level/show.html.twig', [
            'level' => $level,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_level_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Level $level, LevelRepository $levelRepository): Response
    {
        $form = $this->createForm(LevelType::class, $level);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $levelRepository->save($level, true);

            return $this->redirectToRoute('app_admin_level_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_level/edit.html.twig', [
            'level' => $level,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_level_delete', methods: ['POST'])]
    public function delete(Request $request, Level $level, LevelRepository $levelRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$level->getId(), $request->request->get('_token'))) {
            $levelRepository->remove($level, true);
        }

        return $this->redirectToRoute('app_admin_level_index', [], Response::HTTP_SEE_OTHER);
    }
}
