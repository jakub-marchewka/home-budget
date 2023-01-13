<?php

declare(strict_types=1);

namespace App\Service\Notification;

use App\Entity\Notification;
use App\Entity\User;
use App\Repository\NotificationRepository;

class NotificationCreateService
{
    public function __construct(private NotificationRepository $repository)
    {
    }

    public function create(Notification $notification, User $user): Notification
    {
        $notification->setUser($user);
        $this->repository->save($notification, true);
        return $notification;
    }
}