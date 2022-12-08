<?php

namespace App\Controller;

use App\Repository\CharacteristicRepository;
use App\Repository\EntityRepository;
use App\Repository\EvidenceRepository;
use App\Repository\LevelRepository;
use App\Repository\MapRepository;
use App\Repository\ParamLevelMapSizeRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Service\ConversionService;
use function PHPUnit\Framework\isEmpty;

class InvestigationController extends AbstractController
{
    #[Route('/investigation', name: 'app_investigation')]
    public function index(
        ?UserInterface     $user,
        LevelRepository    $levelRepository,
        MapRepository      $mapRepository,
        EvidenceRepository $evidenceRepository,
        EntityRepository   $entityRepository
    ): Response
    {
        // If no user connected, redirect to login page
        if (is_null($user)) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('investigation/index.html.twig', [
            'levels' => $levelRepository->findAll(),
            'maps' => $mapRepository->findAll(),
            'evidences' => $evidenceRepository->findAll(),
            'entities' => $entityRepository->findAllOrderName(),
        ]);
    }

    /**
     * @param Request $request
     * @param ParamLevelMapSizeRepository $paramLevelMapSizeRepository
     * @param MapRepository $mapRepository
     * @param ConversionService $conversionService
     * @return Response
     * @throws \Exception
     */
    #[Route('/investigation/chaseDuration/{data}', name: 'app_investigation_chase_duration')]
    public function getChaseDuration(
        Request                     $request,
        ParamLevelMapSizeRepository $paramLevelMapSizeRepository,
        MapRepository               $mapRepository,
        CharacteristicRepository    $characteristicRepository,
        ConversionService           $conversionService
    ): Response
    {
        $data = json_decode($request->get('data'), true);

        $huntDuration = $paramLevelMapSizeRepository->findOneBy(
            [
                'level' => $data['levelId'],
                'mapSize' => $mapRepository->find($data['mapId'])->getMapSize()->getId(),
                'name' => 'Hunt Duration',
            ]
        );

        $min = date_format($huntDuration->getDuration(), "i");
        $sec = date_format($huntDuration->getDuration(), "s");
        $chaseDuration = $conversionService->minSecInStr($min, $sec);

        $addingToHuntTime = $characteristicRepository->findOneBy(['name' => 'cursed hunt time'])->getValue();

        $cursed = new DateTime(date("H:i:s", strtotime($addingToHuntTime, strtotime(date_format($huntDuration->getDuration(), "H:i:s")))));
        $minCursed = date_format($cursed, 'i');
        $secCursed = date_format($cursed, 's');
        $chaseDurationCursed = $conversionService->minSecInStr($minCursed, $secCursed);

        return $this->json([
            'chaseDuration' => $chaseDuration,
            'chaseDurationCursed' => $chaseDurationCursed,
        ]);
    }

    #[Route('/investigation/entityEvidences/{data}', name: 'app_investigation_entity_evidences')]
    public function getEntityEvidences(
        Request          $request,
        EntityRepository $entityRepository,
    ): Response
    {
        $data = json_decode($request->get('data'), true);

        $evidences = $entityRepository->find($data['id'])->getEvidences();
        $evidenceNames = [];
        foreach ($evidences as $key => $evidence) {
            $evidenceNames [$key] = $evidence->getName();
        }

        return $this->json([
            'evidenceNames' => $evidenceNames
        ]);
    }

    #[Route('/investigation/evidenceEntities/{data}', name: 'app_investigation_evidence_entities')]
    public function getEvidenceEntities(
        Request            $request,
        EvidenceRepository $evidenceRepository,
    ): Response
    {
        $data = json_decode($request->get('data'), true);

        $entityNames = [];
        foreach ($data as $evidence) {
            $entities = $evidenceRepository->find($evidence['id'])->getEntities();
            $arrayTemp = [];
            foreach ($entities as $entity) {
                if (empty($entityNames)) {
                    $arrayTemp[] = $entity->getName();
                } else {
                    if (in_array($entity->getName(), $entityNames)) {
                        $arrayTemp[] = $entity->getName();
                    }
                }
            }
            $entityNames = $arrayTemp;
        }
        return $this->json(['entityNames' => $entityNames]);
    }
}
