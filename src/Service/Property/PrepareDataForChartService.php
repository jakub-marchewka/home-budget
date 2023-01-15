<?php

declare(strict_types=1);

namespace App\Service\Property;

use App\Entity\Property;
use App\Enum\BillTypeEnum;
use App\Repository\BillRepository;

class PrepareDataForChartService
{
    public function __construct(private BillRepository $repository)
    {
    }

    public function getData(Property $property): array
    {
        $data = $this->repository->groupBillsByTypeForProperty($property);
        $labels = [];
        $dataSets = [];
        foreach ($data as $row) {
            $labels[] = $row['type']->getLabel();
            $dataSets[] = $row['sum']/100;
        }
        return ['labels' => $labels, 'dataSets' => $dataSets];
    }
}