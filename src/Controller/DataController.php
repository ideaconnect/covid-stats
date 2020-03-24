<?php

namespace App\Controller;

use App\Repository\StatsSourceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class DataController extends AbstractController
{
    protected $serializer;
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @Route("/data/{code}", name="show_results")
     */
    public function showData(string $code, StatsSourceRepository $stats, Request $request)
    {
        if (!$statsData = $stats->findOneBy(['code' => $code])) {
            return $this->response([
                'success' => false,
                'error' => 'Invalid source identifier'
            ], 404, $request);
        }

        $data = $statsData->toArray();
        $data['success'] = true;

        return $this->response($data, 200, $request);
    }

    protected function response($data, $code, Request $request)
    {
        $mapping = [
            'text/xml' => 'xml',
            'application/json' => 'json',
            'text/html' => 'html'
        ];

        $reversed = array_flip($mapping);

        $finalType = 'html';
        $finalContentType = 'text/html';
        if ($request->query->has('format') && in_array($request->query->get('format'), $mapping)) {
            $type = $request->query->get('format');
            $finalContentType = $reversed[$type];
            $finalType = $type;
        } else {
            foreach ($request->getAcceptableContentTypes() as $type) {
                if (isset($mapping[$type])) {
                    $finalContentType = $type;
                    $finalType = $mapping[$type];
                    break;
                }
            }
        }

        $finalType = $finalType ?? 'html';
        $finalContentType = $finalContentType ?? 'text/html';

        $response = new Response();
        $response->headers->set('Content-type', $finalContentType);

        if ($finalType !== 'html') {
            $responseString = $this->serializer->serialize($data, $finalType);
        } else {
            return $this->render('data.html.twig');
        }

        $response->setContent($responseString);

        return $response;
    }
}
