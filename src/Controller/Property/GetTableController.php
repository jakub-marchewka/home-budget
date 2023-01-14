<?php

declare(strict_types=1);

namespace App\Controller\Property;

use App\Service\Property\FindPropertiesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetTableController extends AbstractController
{
    #[Route('/portal/property/table', name: 'app_property_table')]
    public function __invoke(FindPropertiesService $findPropertiesService): Response
    {
        return $this->render('property/propertyTable.html.twig', [
            'properties' => $findPropertiesService->find($this->getUser()),
        ]);
    }
}