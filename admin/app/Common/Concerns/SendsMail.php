<?php

namespace App\Common\Concerns;

use App\Jobs\SendMailJob;

trait SendsMail
{

    public static function bootSendsMail()
    {
        static::created(function($item) {
            $item->notifyAdmin();
        });
    }

    public function notifyAdmin()
    {
        if ($this->getAddress()) {
            SendMailJob::dispatch($this->getNotificationMail());
        }
    }

    public function getAddress() : string
    {
        return 'nurik9293709@gmail.com';
    }
}
