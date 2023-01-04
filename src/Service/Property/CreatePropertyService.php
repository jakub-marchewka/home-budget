<?php

declare(strict_types=1);

namespace App\Service\Property;

use App\Entity\Property;
use App\Entity\User;
use App\Repository\PropertyRepository;

class CreatePropertyService
{
    public function __construct(private PropertyRepository $repository)
    {
    }

    public function create(string $name, User $user): Property
    {
        $property = new Property();
        $property->setName($name);
        $property->setOwner($user);
        $this->repository->save($property, true);
        return $property;
    }
}