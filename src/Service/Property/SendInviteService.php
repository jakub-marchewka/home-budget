<?php

declare(strict_types=1);

namespace App\Service\Property;

use App\Entity\TenantInvite;
use App\Entity\User;
use App\Repository\PropertyRepository;
use App\Repository\TenantInviteRepository;

class SendInviteService
{
    public function __construct(private TenantInviteRepository $tenantInviteRepository)
    {
    }

    public function invite(User $user, TenantInvite $tenantInvite): TenantInvite
    {
        $this->tenantInviteRepository->save($tenantInvite, true);
        return $tenantInvite;
    }

}