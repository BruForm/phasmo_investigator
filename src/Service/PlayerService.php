<?php

namespace App\Service;

class PlayerService
{
    function createStats(array $stats): array
    {
        foreach ($stats as $i => $stat) {
            $nbInvestigTotal = $stat['nbInvestig'];
            $nbSuccessTotal = $stat['nbSuccess'];
            $percentSuccessTotal = ($nbInvestigTotal > 0) ? round((100 * $nbSuccessTotal) / $nbInvestigTotal) : 0;
            $nbFailTotal = $stat['nbInvestig'] - $stat['nbSuccess'];
            $percentFailTotal = ($nbInvestigTotal > 0) ? round((100 * $nbFailTotal) / $nbInvestigTotal) : 0;
            $stats[$i] = [
                'nbInvestigTotal' => $nbInvestigTotal,
                'nbSuccessTotal' => $nbSuccessTotal,
                'percentSuccessTotal' => $percentSuccessTotal,
                'nbFailTotal' => $nbFailTotal,
                'percentFailTotal' => $percentFailTotal,
            ];
        }

        return $stats;
    }

}