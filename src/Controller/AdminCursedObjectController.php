<?php

namespace App\Controller;

use App\Entity\CursedObject;
use App\Form\CursedObjectType;
use App\Repository\CursedObjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/cursed/object')]
class AdminCursedObjectController extends AbstractController
{
    #[Route('/', name: 'app_admin_cursed_object_index', methods: ['GET'])]
    public function index(CursedObjectRepository $cursedObjectRepository): Response
    {
        return $this->render('admin_cursed_object/index.html.twig', [
            'cursed_objects' => $cursedObjectRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_cursed_object_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CursedObjectRepository $cursedObjectRepository): Response
    {
        $cursedObject = new CursedObject();
        $form = $this->createForm(CursedObjectType::class, $cursedObject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cursedObjectRepository->save($cursedObject, true);

            return $this->redirectToRoute('app_admin_cursed_object_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_cursed_object/new.html.twig', [
            'cursed_object' => $cursedObject,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_cursed_object_show', methods: ['GET'])]
    public function show(CursedObject $cursedObject): Response
    {
        return $this->render('admin_cursed_object/show.html.twig', [
            'cursed_object' => $cursedObject,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_cursed_object_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CursedObject $cursedObject, CursedObjectRepository $cursedObjectRepository): Response
    {
        $form = $this->createForm(CursedObjectType::class, $cursedObject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cursedObjectRepository->save($cursedObject, true);

            return $this->redirectToRoute('app_admin_cursed_object_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_cursed_object/edit.html.twig', [
            'cursed_object' => $cursedObject,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_cursed_object_delete', methods: ['POST'])]
    public function delete(Request $request, CursedObject $cursedObject, CursedObjectRepository $cursedObjectRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cursedObject->getId(), $request->request->get('_token'))) {
            $cursedObjectRepository->remove($cursedObject, true);
        }

        return $this->redirectToRoute('app_admin_cursed_object_index', [], Response::HTTP_SEE_OTHER);
    }
}
