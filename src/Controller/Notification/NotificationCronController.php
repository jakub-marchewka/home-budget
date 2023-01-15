<?php

declare(strict_types=1);

namespace App\Controller\Notification;

use App\Service\Notification\NotificationCronService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class NotificationCronController extends AbstractController
{
    #[Route('/cron/notification/{password}', name: 'app_notification_cron')]
    public function __invoke(string $password, NotificationCronService $cronService): JsonResponse
    {
        if ($password === $_ENV['CRON_PASSWORD']) {
            $cronService->sendEmails();
            return $this->json(['status' => 'success']);
        }
        return $this->json(['status' => 'error']);
    }
}