<?php

declare(strict_types=1);

namespace App\Controller\Property;

use App\Service\Property\FindPropertiesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyIndexController extends AbstractController
{
    #[Route('/portal/property', name: 'app_property_index')]
    public function __invoke(FindPropertiesService $findPropertiesService): Response
    {
        return $this->render('property/property.html.twig', [
            'properties' => $findPropertiesService->find($this->getUser()),
        ]);
    }
}