<?php

declare(strict_types=1);

namespace App\Controller\Property;

use App\Service\Property\FindPropertiesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PropertyCreateController extends AbstractController
{
    #[Route('/portal/property/create', name: 'app_property_create')]
    public function __invoke(Request $request, FindPropertiesService $findPropertiesService)
    {

        return $this->render('property/propertyTable.html.twig', [
            'properties' => $findPropertiesService->find($this->getUser())
        ]);
    }
}