<?php

namespace App\Controller;

use App\Entity\MapSize;
use App\Form\MapSizeType;
use App\Repository\MapSizeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/map_size')]
class AdminMapSizeController extends AbstractController
{
    #[Route('/', name: 'app_admin_map_size_index', methods: ['GET'])]
    public function index(MapSizeRepository $mapSizeRepository): Response
    {
        return $this->render('admin_map_size/index.html.twig', [
            'map_sizes' => $mapSizeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_map_size_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MapSizeRepository $mapSizeRepository): Response
    {
        $mapSize = new MapSize();
        $form = $this->createForm(MapSizeType::class, $mapSize);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mapSizeRepository->save($mapSize, true);

            return $this->redirectToRoute('app_admin_map_size_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_map_size/new.html.twig', [
            'map_size' => $mapSize,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_map_size_show', methods: ['GET'])]
    public function show(MapSize $mapSize): Response
    {
        return $this->render('admin_map_size/show.html.twig', [
            'map_size' => $mapSize,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_map_size_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MapSize $mapSize, MapSizeRepository $mapSizeRepository): Response
    {
        $form = $this->createForm(MapSizeType::class, $mapSize);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mapSizeRepository->save($mapSize, true);

            return $this->redirectToRoute('app_admin_map_size_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_map_size/edit.html.twig', [
            'map_size' => $mapSize,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_map_size_delete', methods: ['POST'])]
    public function delete(Request $request, MapSize $mapSize, MapSizeRepository $mapSizeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mapSize->getId(), $request->request->get('_token'))) {
            $mapSizeRepository->remove($mapSize, true);
        }

        return $this->redirectToRoute('app_admin_map_size_index', [], Response::HTTP_SEE_OTHER);
    }
}
