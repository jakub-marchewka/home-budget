<?php

declare(strict_types=1);

namespace App\Controller\Property;

use App\Entity\Property;
use App\Service\Property\PrepareDataForChartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyChartController extends AbstractController
{
    #[Route('/portal/property/chart/{property}', name: 'app_property_chart')]
    public function __invoke(Property $property, PrepareDataForChartService $chartService): Response
    {
        return $this->render('property/chart.html.twig', [
            'property' => $property,
            'data' => json_encode($chartService->getData($property)),
        ]);
    }
}