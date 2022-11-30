<?php

namespace App\Controller;

use App\Repository\LevelRepository;
use App\Repository\MapRepository;
use App\Repository\ParamLevelMapSizeRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Service\ConversionService;

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
     * @param int $levelId
     * @param int $mapId
     * @param ParamLevelMapSizeRepository $paramLevelMapSizeRepository
     * @param MapRepository $mapRepository
     * @param ConversionService $conversionService
     * @return Response
     * @throws \Exception
     */
    #[Route('/investigation/chaseDuration/{levelId}/{mapId}', name: 'app_investigation_chase_duration')]
    public function getChaseDuration(
        int                         $levelId,
        int                         $mapId,
        ParamLevelMapSizeRepository $paramLevelMapSizeRepository,
        MapRepository               $mapRepository,
        ConversionService           $conversionService
    ): Response
    {
        $huntDuration = $paramLevelMapSizeRepository->findOneBy(
            [
                'level' => $levelId,
                'mapSize' => $mapRepository->find($mapId)->getMapSize()->getId(),
                'name' => 'Hunt Duration',
            ]
        );

        $min = date_format($huntDuration->getDuration(), "i");
        $sec = date_format($huntDuration->getDuration(), "s");
        $chaseDuration = $conversionService->minSecInStr($min, $sec);

        $cursed = new DateTime(date("H:i:s", strtotime('+20seconds', strtotime(date_format($huntDuration->getDuration(), "H:i:s")))));
        $minCursed = date_format($cursed, 'i');
        $secCursed = date_format($cursed, 's');
        $chaseDurationCursed = $conversionService->minSecInStr($minCursed, $secCursed);

        return $this->json([
            'chaseDuration' => $chaseDuration,
            'chaseDurationCursed' => $chaseDurationCursed,
        ]);
    }
}
