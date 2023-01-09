<?php

declare(strict_types=1);

namespace App\Service\Property;

use App\Entity\Property;
use App\Entity\TenantInvite;
use App\Repository\PropertyRepository;
use App\Repository\TenantInviteRepository;

class AcceptInviteService
{
    public function __construct(
        private TenantInviteRepository $tenantInviteRepository,
        private PropertyRepository $propertyRepository
    ) {
    }

    public function accept(TenantInvite $tenantInvite): ?Property
    {
        $property = $tenantInvite->getProperty();
        $property->addTenant($tenantInvite->getTenant());
        $this->propertyRepository->save($property, true);
        $this->tenantInviteRepository->remove($tenantInvite, true);
        return $property;
    }
}