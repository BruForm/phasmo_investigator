<?php

namespace App\Controller;

use App\Repository\LevelRepository;
use App\Repository\MapRepository;
use App\Repository\ParamLevelMapSizeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class InvestigationController extends AbstractController
{
    #[Route('/investigation', name: 'app_investigation')]
    public function index(
        ?UserInterface  $user,
        LevelRepository $levelRepository,
        MapRepository   $mapRepository,
    ): Response
    {
        // If no user connected, redirect to login page
        if (is_null($user)) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('investigation/index.html.twig', [
            'levels' => $levelRepository->findAll(),
            'maps' => $mapRepository->findAll(),
        ]);
    }

    /**
     * Renvoie la durée de chase en fonction de la map et du level
     * @param int $levelId
     * @param int $mapId
     * @param ParamLevelMapSizeRepository $paramLevelMapSizeRepository
     * @param MapRepository $mapRepository
     * @return Response
     */
    #[Route('/investigation/chaseDuration/{levelId}/{mapId}', name: 'app_investigation_chase_duration')]
    public function getChaseDuration(int $levelId, int $mapId, ParamLevelMapSizeRepository $paramLevelMapSizeRepository, MapRepository $mapRepository): Response
    {
        $res = $paramLevelMapSizeRepository->findOneBy(
            [
                'level' => $levelId,
                'mapSize' => $mapRepository->find($mapId)->getMapSize()->getId(),
                'name' => 'Hunt Duration',
            ]
        );
//        dd(date("i:s", strtotime('+20seconds', strtotime(date_format($res->getDuration(), "H:i:s")))));
        return $this->json([
            'chaseDuration' => date_format($res->getDuration(), "i:s"),
            'chaseDurationCursed' => date("i:s", strtotime('+20seconds', strtotime(date_format($res->getDuration(), "H:i:s")))),
        ]);
    }
}
