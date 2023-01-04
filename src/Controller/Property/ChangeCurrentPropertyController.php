<?php

declare(strict_types=1);

namespace App\Controller\Property;

use App\Service\Property\ChangeCurrentPropertyService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ChangeCurrentPropertyController extends AbstractController
{
    #[Route('/portal/property/current', name: 'app_property_current')]
    public function __invoke(Request $request, ChangeCurrentPropertyService $currentPropertyService): JsonResponse
    {
        $propertyId = $request->get('propertyId');
        try {
            $currentPropertyService->change($this->getUser(), $propertyId);
        } catch (Exception $e) {
            return $this->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
        return $this->json([
            'status' => 'success'
        ]);

    }
}