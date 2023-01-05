<?php

declare(strict_types=1);

namespace App\Controller\Bill;

use App\Service\Bill\GetBillsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BillArchiveController extends AbstractController
{
    #[Route('/portal/bill/archive', name: 'app_bill_archive')]
    public function __invoke(GetBillsService $billsService): Response
    {
        return $this->render('bill/archive.html.twig',[
            'bills' => $billsService->find($this->getUser()->getCurrentProperty(), true)
        ]);
    }
}