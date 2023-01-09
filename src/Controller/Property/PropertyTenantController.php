<?php

declare(strict_types=1);

namespace App\Controller\Property;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyTenantController extends AbstractController
{
    #[Route('/portal/property/tenant', name: 'app_property_tenant')]
    public function __invoke(): Response
    {
        return $this->render('property/propertyTenant.html.twig');
    }
}