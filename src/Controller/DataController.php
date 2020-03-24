<?php

namespace App\Controller;

use App\Repository\StatsSourceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DataController extends AbstractController
{
    /**
     * @Route("/data/{code}", name="show_results")
     */
    public function showData(string $code, StatsSourceRepository $stats)
    {
        if(!$statsData = $stats->findOneBy(['code' => $code])) {
            return new JsonResponse([
                'success' => false,
                'error' => 'Invalid source identifier'
            ], 404);
        }

        $data = $statsData->toArray();
        $data['success'] = true;
        return new JsonResponse($data);
    }
}
