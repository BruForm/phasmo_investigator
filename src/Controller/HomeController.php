<?php

namespace App\Controller;

use App\Repository\LevelRepository;
use App\Repository\MapSizeRepository;
use App\Repository\ParamLevelMapSizeRepository;
use App\Repository\PlayerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\TraductionService;
use App\Service\PlayerService;
use Symfony\Component\Security\Core\User\UserInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, LevelRepository $levelRepository, MapSizeRepository $mapSizeRepository, ParamLevelMapSizeRepository $paramLevelMapSizeRepository, TraductionService $traductionService, PlayerRepository $playerRepository, PlayerService $playerService, ?UserInterface $user): Response
    {
        $levels = $levelRepository->findAll();
        $mapSizes = $mapSizeRepository->findAll();
        // Traduction EN => FR
        foreach ($mapSizes as $mapSize) {
            $mapSize->setName(ucfirst($traductionService->translateEnFr($mapSize->getName())));
        }
        $params = $paramLevelMapSizeRepository->findAllOrderByMapSizeLevel();
        $stats = $playerService->createStats($playerRepository->sumForStats());

        $statsUser = [];
        if (!is_null($user)) {
            $statsUser = $playerService->createStats($playerRepository->sumForStatsByEmail($user->getUserIdentifier()));
        }

        return $this->render('home/index.html.twig', [
            'levels' => $levels,
            'mapSizes' => $mapSizes,
            'params' => $params,
            'stats' => $stats[0],
            'statsUser' => $statsUser,
        ]);
    }
}
