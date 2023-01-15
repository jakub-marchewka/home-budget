<?php

declare(strict_types=1);

namespace App\Controller\Notification;

use App\Repository\NotificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetTableController extends AbstractController
{
    #[Route('/portal/notification/table', name: 'app_notification_table')]
    public function __invoke(NotificationRepository $repository): Response
    {
        $notifications = $repository->findBy(['user' => $this->getUser()]);
        return $this->render('notification/notificationTable.html.twig', [
            'notifications' => $notifications,
        ]);
    }
}