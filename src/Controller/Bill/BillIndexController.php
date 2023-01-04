<?php

declare(strict_types=1);

namespace App\Controller\Bill;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BillIndexController extends AbstractController
{

    #[Route('/portal/bill', name: 'app_bill_index')]
    public function __invoke(): RedirectResponse|Response
    {
        if (!$this->getUser()->getCurrentProperty()) {
            $this->addFlash('error', 'Nie posiadasz aktywnej nieruchomości');
            return $this->redirectToRoute('app_property_index');
        }
        return $this->render('bill/bill.html.twig');
    }
}