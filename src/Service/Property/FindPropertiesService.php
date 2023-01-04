<?php

declare(strict_types=1);

namespace App\Service\Property;

use App\Entity\User;
use App\Repository\PropertyRepository;

class FindPropertiesService
{
    public function __construct(private PropertyRepository $repository)
    {
    }

    public function find(User $user)
    {
        
    }
}