<?php

declare(strict_types=1);

namespace App\Controller\Property;

use App\Entity\TenantInvite;
use App\Service\Property\AcceptInviteService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class PropertyAcceptInviteController extends AbstractController
{
    #[Route('/portal/property/invite/accept/{tenantInvite}', name: 'app_property_invite_accept')]
    public function __invoke(TenantInvite $tenantInvite, AcceptInviteService $acceptInviteService): RedirectResponse
    {
        if ($this->getUser() !== $tenantInvite->getTenant()) {
            $this->addFlash('error', 'Wystąpił błąd.');
        } else {
            $acceptInviteService->accept($tenantInvite);
            $this->addFlash('success', 'Zaproszenie zostało przyjęte.');
        }
        return $this->redirectToRoute('app_property_index');
    }
}