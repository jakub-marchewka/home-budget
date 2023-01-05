<?php

declare(strict_types=1);

namespace App\Service\Bill;

use App\Entity\Property;
use App\Repository\BillRepository;

class GetBillsService
{
    public function __construct(private BillRepository $repository)
    {
    }

    public function find(Property $property, bool $archived): ?array
    {
        return $this->repository->findBy(['property' => $property, 'archived' => $archived]);
    }
}