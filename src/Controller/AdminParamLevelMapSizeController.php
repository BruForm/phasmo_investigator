<?php

namespace App\Controller;

use App\Entity\ParamLevelMapSize;
use App\Form\ParamLevelMapSizeType;
use App\Repository\ParamLevelMapSizeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/param_level_map_size')]
#[Security("is_granted('ROLE_ADMIN')")]
class AdminParamLevelMapSizeController extends AbstractController
{
    #[Route('/', name: 'app_admin_param_level_map_size_index', methods: ['GET'])]
    public function index(ParamLevelMapSizeRepository $paramLevelMapSizeRepository): Response
    {
        return $this->render('admin_param_level_map_size/index.html.twig', [
            'param_level_map_sizes' => $paramLevelMapSizeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_param_level_map_size_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ParamLevelMapSizeRepository $paramLevelMapSizeRepository): Response
    {
        $paramLevelMapSize = new ParamLevelMapSize();
        $form = $this->createForm(ParamLevelMapSizeType::class, $paramLevelMapSize);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $paramLevelMapSizeRepository->save($paramLevelMapSize, true);

            return $this->redirectToRoute('app_admin_param_level_map_size_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_param_level_map_size/new.html.twig', [
            'param_level_map_size' => $paramLevelMapSize,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_param_level_map_size_show', methods: ['GET'])]
    public function show(ParamLevelMapSize $paramLevelMapSize): Response
    {
        return $this->render('admin_param_level_map_size/show.html.twig', [
            'param_level_map_size' => $paramLevelMapSize,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_param_level_map_size_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ParamLevelMapSize $paramLevelMapSize, ParamLevelMapSizeRepository $paramLevelMapSizeRepository): Response
    {
        $form = $this->createForm(ParamLevelMapSizeType::class, $paramLevelMapSize);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $paramLevelMapSizeRepository->save($paramLevelMapSize, true);

            return $this->redirectToRoute('app_admin_param_level_map_size_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_param_level_map_size/edit.html.twig', [
            'param_level_map_size' => $paramLevelMapSize,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_param_level_map_size_delete', methods: ['POST'])]
    public function delete(Request $request, ParamLevelMapSize $paramLevelMapSize, ParamLevelMapSizeRepository $paramLevelMapSizeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$paramLevelMapSize->getId(), $request->request->get('_token'))) {
            $paramLevelMapSizeRepository->remove($paramLevelMapSize, true);
        }

        return $this->redirectToRoute('app_admin_param_level_map_size_index', [], Response::HTTP_SEE_OTHER);
    }
}
