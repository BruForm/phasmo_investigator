<?php

namespace App\Controller;

use App\Repository\LevelRepository;
use App\Repository\MapSizeRepository;
use App\Repository\ParamLevelMapSizeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Traduction;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, LevelRepository $levelRepository, MapSizeRepository $mapSizeRepository, ParamLevelMapSizeRepository $paramLevelMapSizeRepository, Traduction $traduction): Response
    {
        $levels = $levelRepository->findAll();
        $mapSizes = $mapSizeRepository->findAll();
        // Traduction EN => FR
        foreach ($mapSizes as $mapSize) {
            $mapSize->setName(ucfirst($traduction->translateEnFr($mapSize->getName())));
        }

        $params = $paramLevelMapSizeRepository->findAllOrderByMapSizeLevel();

        return $this->render('home/index.html.twig', [
            'levels' => $levels,
            'mapSizes' => $mapSizes,
            'params' => $params,
        ]);
    }
}
