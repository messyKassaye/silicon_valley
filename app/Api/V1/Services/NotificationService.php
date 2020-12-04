<?php


namespace App\Api\V1\Services;


use App\EntityType;
use App\Notification;

class NotificationService
{

    public function notify($entity_id,$actor_id,$notifier_id,$message,$path){
        $entityType = EntityType::find(1);
        $notification = new Notification();
        $notification->entity_type_id = $entity_id;
        $notification->notifier_id = $notifier_id;
        $notification->actor_id = $actor_id;
        $notification->message = $message;
        $notification->notification_path =$path;
        $notification->save();
    }
}