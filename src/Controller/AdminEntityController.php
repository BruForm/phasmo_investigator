<?php

namespace App\Controller;

use App\Entity\Entity;
use App\Form\EntityType;
use App\Repository\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/entity')]
#[Security("is_granted('ROLE_ADMIN')")]
class AdminEntityController extends AbstractController
{
    #[Route('/', name: 'app_admin_entity_index', methods: ['GET'])]
    public function index(EntityRepository $entityRepository): Response
    {
        return $this->render('admin_entity/index.html.twig', [
            'entities' => $entityRepository->findAllOrderName(),
        ]);
    }

    #[Route('/new', name: 'app_admin_entity_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityRepository $entityRepository): Response
    {
        $entity = new Entity();
        $form = $this->createForm(EntityType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityRepository->save($entity, true);

            return $this->redirectToRoute('app_admin_entity_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_entity/new.html.twig', [
            'entity' => $entity,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_entity_show', methods: ['GET'])]
    public function show(Entity $entity): Response
    {
        return $this->render('admin_entity/show.html.twig', [
            'entity' => $entity,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_entity_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Entity $entity, EntityRepository $entityRepository): Response
    {
        $form = $this->createForm(EntityType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityRepository->save($entity, true);

            return $this->redirectToRoute('app_admin_entity_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_entity/edit.html.twig', [
            'entity' => $entity,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_entity_delete', methods: ['POST'])]
    public function delete(Request $request, Entity $entity, EntityRepository $entityRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entity->getId(), $request->request->get('_token'))) {
            $entityRepository->remove($entity, true);
        }

        return $this->redirectToRoute('app_admin_entity_index', [], Response::HTTP_SEE_OTHER);
    }
}
