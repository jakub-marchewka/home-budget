<?php

declare(strict_types=1);

namespace App\Controller\Property;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PropertyDeleteController extends AbstractController
{
    #[Route('/portal/property/delete/{property}', name: 'app_property_delete')]
    public function __invoke(Property $property, PropertyRepository $repository): JsonResponse
    {
        if ($property->getOwner() === $this->getUser()) {
            $repository->remove($property, true);
            return $this->json(['status' => 'success']);
        }
        return $this->json(['status' => 'error']);
    }
}