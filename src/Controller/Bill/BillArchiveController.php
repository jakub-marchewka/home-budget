<?php

declare(strict_types=1);

namespace App\Controller\Bill;

use App\Form\ArchiveSearchType;
use App\Repository\BillRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BillArchiveController extends AbstractController
{
    #[Route('/portal/bill/archive', name: 'app_bill_archive', methods: 'get')]
    public function __invoke(BillRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $form = $this->createForm(ArchiveSearchType::class, null, [
            'method' => 'GET',
        ])->handleRequest($request);
        $pagination = $paginator->paginate(
            $repository->archiveSearch($this->getUser()->getCurrentProperty(), $form), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            2 /*limit per page*/
        );
        return $this->render('bill/archive.html.twig',[
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }
}