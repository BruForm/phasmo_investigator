<?php

namespace App\Controller;

use App\Entity\OptionalGoal;
use App\Form\OptionalGoalType;
use App\Repository\OptionalGoalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/optional_goal')]
class AdminOptionalGoalController extends AbstractController
{
    #[Route('/', name: 'app_admin_optional_goal_index', methods: ['GET'])]
    public function index(OptionalGoalRepository $optionalGoalRepository): Response
    {
        return $this->render('admin_optional_goal/index.html.twig', [
            'optional_goals' => $optionalGoalRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_optional_goal_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OptionalGoalRepository $optionalGoalRepository): Response
    {
        $optionalGoal = new OptionalGoal();
        $form = $this->createForm(OptionalGoalType::class, $optionalGoal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $optionalGoalRepository->save($optionalGoal, true);

            return $this->redirectToRoute('app_admin_optional_goal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_optional_goal/new.html.twig', [
            'optional_goal' => $optionalGoal,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_optional_goal_show', methods: ['GET'])]
    public function show(OptionalGoal $optionalGoal): Response
    {
        return $this->render('admin_optional_goal/show.html.twig', [
            'optional_goal' => $optionalGoal,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_optional_goal_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, OptionalGoal $optionalGoal, OptionalGoalRepository $optionalGoalRepository): Response
    {
        $form = $this->createForm(OptionalGoalType::class, $optionalGoal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $optionalGoalRepository->save($optionalGoal, true);

            return $this->redirectToRoute('app_admin_optional_goal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_optional_goal/edit.html.twig', [
            'optional_goal' => $optionalGoal,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_optional_goal_delete', methods: ['POST'])]
    public function delete(Request $request, OptionalGoal $optionalGoal, OptionalGoalRepository $optionalGoalRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$optionalGoal->getId(), $request->request->get('_token'))) {
            $optionalGoalRepository->remove($optionalGoal, true);
        }

        return $this->redirectToRoute('app_admin_optional_goal_index', [], Response::HTTP_SEE_OTHER);
    }
}
