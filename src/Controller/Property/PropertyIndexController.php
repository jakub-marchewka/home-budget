<?php

declare(strict_types=1);

namespace App\Controller\Property;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyIndexController extends AbstractController
{
    #[Route('/portal/property', name: 'app_property_index')]
    public function __invoke(PropertyRepository $repository): Response
    {
        return $this->render('property/property.html.twig', [
            'properties' => $repository->findAll(),
        ]);
    }
}