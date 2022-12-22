<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Player;
use App\Repository\CharacteristicRepository;
use App\Repository\EntityRepository;
use App\Repository\EvidenceRepository;
use App\Repository\GameRepository;
use App\Repository\LevelRepository;
use App\Repository\MapRepository;
use App\Repository\ParamLevelMapSizeRepository;
use App\Repository\PlayerRepository;
use App\Repository\SkinRepository;
use App\Repository\TypeRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Service\ConversionService;

class InvestigationController extends AbstractController
{
    /**
     * @param UserInterface|null $user
     * @param LevelRepository $levelRepository
     * @param MapRepository $mapRepository
     * @param EvidenceRepository $evidenceRepository
     * @param EntityRepository $entityRepository
     * @return Response
     */
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

    /**
     * @param Request $request
     * @param EntityRepository $entityRepository
     * @return Response
     */
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

    /**
     * @param Request $request
     * @param EvidenceRepository $evidenceRepository
     * @return Response
     */
    #[Route('/investigation/evidenceEntities/{data}', name: 'app_investigation_evidence_entities')]
    public function getEvidenceEntities(
        Request            $request,
        EvidenceRepository $evidenceRepository,
    ): Response
    {
        $data = json_decode($request->get('data'), true);

        $entityNames = [];
        foreach ($data as $tabId => $evidence) {
            $entities = $evidenceRepository->find($evidence['id'])->getEntities();

            $entityTemp = [];
            foreach ($entities as $entity) {
                $entityTemp[] = $entity->getName();
            }
            if ($tabId === 0) {
                $entityNames = $entityTemp;
            } else {
                // NB : array_values permet de ré-indexer les clés du tableau filtrer
                $entityNames = array_values(array_filter($entityNames, function ($name) use ($entityTemp) {
                    return in_array($name, $entityTemp);
                }));
            }
// OLD VERSION without using array_filter
//            $entityTemp = [];
//            foreach ($entities as $entity) {
//                if ($tabId === 0) {
//                    $entityTemp[] = $entity->getName();
//                } else {
//                    if (in_array($entity->getName(), $entityNames)) {
//                        $entityTemp[] = $entity->getName();
//                    }
//                }
//            }
//            $entityNames = $entityTemp;
        }
        return $this->json(['entityNames' => $entityNames]);
    }

    /**
     * @param Request $request
     * @param EntityRepository $entityRepository
     * @return Response
     * @throws \Exception
     */
    #[Route('/investigation/entityInfos/{data}', name: 'app_investigation_entity_infos')]
    public function getSlideEntities(
        Request           $request,
        EntityRepository  $entityRepository,
        ConversionService $conversionService,
        SkinRepository    $skinRepository,
        TypeRepository    $typeRepository,
    ): Response
    {
        $data = json_decode($request->get('data'), true);
        $entity = $entityRepository->find($data['id']);

        // Types souhaités :
        //      id 5  = sm attack
        $smAttack = "";
        //      id 10 = speed
        $speed = "";
        //      id 6  = stun smudge
        $stunSmudge = "";
        //      id 7  = time attack
        $timeAttack = "";
        //      id 8  = time attack smudge
        $timeAttackSmudge = "";

        $characteristics = $entity->getCharacteristics()->getValues();
        foreach ($characteristics as $characteristic) {
            switch ($characteristic->getType()->getId()) {
                case '5':
                    $smAttack = $characteristic->getValue();
                    break;
                case '6':
                    $temp = new DateTime($characteristic->getValue());
                    $min = date_format($temp, "i");
                    $sec = date_format($temp, "s");
                    $stunSmudge = $conversionService->minSecInStr($min, $sec);
                    break;
                case '7':
                    $temp = new DateTime($characteristic->getValue());
                    $min = date_format($temp, "i");
                    $sec = date_format($temp, "s");
                    $timeAttack = $conversionService->minSecInStr($min, $sec);
                    break;
                case '8':
                    $temp = new DateTime($characteristic->getValue());
                    $min = date_format($temp, "i");
                    $sec = date_format($temp, "s");
                    $timeAttackSmudge = $conversionService->minSecInStr($min, $sec);
                    break;
                case '10':
                    $speed = $characteristic->getValue();
                    break;
            }
        }

        $skinUrl = $skinRepository->findOneRandomByType(
            $typeRepository->findOneBy(['name' => 'skin_entity'])->getId()
        )->getUrl();

        return $this->json([
            'id' => $entity->getId(),
            'name' => $entity->getName(),
            'special_move' => $entity->getSpecialMove(),
            'smAttack' => $smAttack,
            'speed' => $speed,
            'stunSmudge' => $stunSmudge,
            'timeAttack' => $timeAttack,
            'timeAttackSmudge' => $timeAttackSmudge,
            'skin_url' => $skinUrl,
        ]);
    }

    /**
     * @param Request $request
     * @param GameRepository $gameRepository
     * @param PlayerRepository $playerRepository
     * @param LevelRepository $levelRepository
     * @param MapRepository $mapRepository
     * @param EntityRepository $entityRepository
     * @return Response
     */
    #[Route('/investigation/endGame/{data}', name: 'app_investigation_end_game')]
    public function endGame(
        Request          $request,
        GameRepository   $gameRepository,
        PlayerRepository $playerRepository,
        LevelRepository  $levelRepository,
        MapRepository    $mapRepository,
        EntityRepository $entityRepository,
    ): Response
    {
        $data = json_decode($request->get('data'), true);

        $player = $playerRepository->findOneBy(['nickname' => $data['player']]);

        $game = new Game();
        $game->setDuration(new DateTime('00:00:00'));
        $game->setPlayer($player);
        $game->setLevel($levelRepository->find($data['levelId']));
        $game->setMap($mapRepository->find($data['mapId']));
        $game->setChosenEntity($entityRepository->find($data['chosenEntityId']));
        $game->setEntity($entityRepository->find($data['entityId']));

        $player->setNbInvestig($player->getNbInvestig() + 1);
        if($data['result'] === 'success'){
            $player->setNbSuccess($player->getNbSuccess() + 1 );
        }

        try {
            $playerRepository->save($player, true);
            $gameRepository->save($game, true);
            return $this->json([
                'status' => 1,
                'message' => 'game recorded',
            ]);
        } catch (\Exception $exception) {
            return $this->json([
                'status' => 2,
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
