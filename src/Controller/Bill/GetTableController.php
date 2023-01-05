<?php

declare(strict_types=1);

namespace App\Controller\Bill;

use App\Service\Bill\GetBillsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetTableController extends AbstractController
{
    #[Route('/portal/bill/table', name: 'app_bill_table')]
    public function __invoke(GetBillsService $billsService): Response
    {
        $bills = $billsService->find($this->getUser()->getCurrentProperty());
        return $this->render('bill/billTable.html.twig', [
            'bills' => $bills,
        ]);
    }
}