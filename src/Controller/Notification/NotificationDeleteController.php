<?php

declare(strict_types=1);

namespace App\Controller\Notification;

use App\Entity\Notification;
use App\Repository\NotificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class NotificationDeleteController extends AbstractController
{
    #[Route('/portal/notification/delete/{notification}', name: 'app_notification_delete')]
    public function __invoke(Notification $notification, NotificationRepository $repository): JsonResponse
    {
        if ($this->getUser() === $notification->getUser()) {
            $repository->remove($notification, true);
            return $this->json(['status' => 'success']);
        }
        return $this->json(['status' => 'error']);
    }
}