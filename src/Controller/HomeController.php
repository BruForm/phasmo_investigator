<?php

namespace App\Controller;

use App\Repository\LevelRepository;
use App\Repository\MapSizeRepository;
use App\Repository\ParamLevelMapSizeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, LevelRepository $levelRepository, MapSizeRepository $mapSizeRepository, ParamLevelMapSizeRepository $paramLevelMapSizeRepository): Response
    {
        $levels = $levelRepository->findAll();
        $mapSizes = $mapSizeRepository->findAll();
        $params = $paramLevelMapSizeRepository->findAllOrderByMapSizeLevel();
        dump($params);
        return $this->render('home/index.html.twig', [
            'levels' => $levels,
            'mapSizes' => $mapSizes,
            'params' => $params,
        ]);
    }
}
