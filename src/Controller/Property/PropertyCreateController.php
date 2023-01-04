<?php

declare(strict_types=1);

namespace App\Controller\Property;

use App\Service\Property\CreatePropertyService;
use App\Service\Property\FindPropertiesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PropertyCreateController extends AbstractController
{
    #[Route('/portal/property/create', name: 'app_property_create')]
    public function __invoke
    (
        Request $request,
        FindPropertiesService $findPropertiesService,
        CreatePropertyService $createPropertyService
    ): JsonResponse {
        $createPropertyService->create($request->get('name'), $this->getUser());
        $table = $this->renderView('property/propertyTable.html.twig', [
            'properties' => $findPropertiesService->find($this->getUser())
        ]);
        return $this->json([
            'status' => 'success',
            'table' => $table,
            ]);
    }
}