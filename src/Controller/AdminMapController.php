<?php

namespace App\Controller;

use App\Entity\Map;
use App\Form\MapType;
use App\Repository\MapRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/map')]
class AdminMapController extends AbstractController
{
    #[Route('/', name: 'app_admin_map_index', methods: ['GET'])]
    public function index(MapRepository $mapRepository): Response
    {
        return $this->render('admin_map/index.html.twig', [
            'maps' => $mapRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_map_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MapRepository $mapRepository): Response
    {
        $map = new Map();
        $form = $this->createForm(MapType::class, $map);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mapRepository->save($map, true);

            return $this->redirectToRoute('app_admin_map_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_map/new.html.twig', [
            'map' => $map,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_map_show', methods: ['GET'])]
    public function show(Map $map): Response
    {
        return $this->render('admin_map/show.html.twig', [
            'map' => $map,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_map_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Map $map, MapRepository $mapRepository): Response
    {
        $form = $this->createForm(MapType::class, $map);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mapRepository->save($map, true);

            return $this->redirectToRoute('app_admin_map_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_map/edit.html.twig', [
            'map' => $map,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_map_delete', methods: ['POST'])]
    public function delete(Request $request, Map $map, MapRepository $mapRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$map->getId(), $request->request->get('_token'))) {
            $mapRepository->remove($map, true);
        }

        return $this->redirectToRoute('app_admin_map_index', [], Response::HTTP_SEE_OTHER);
    }
}
