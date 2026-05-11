<?php

namespace App\Listeners;

use App\Events\StudentRegistered;
use App\Mail\StudentCredentialsMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendStudentCredentials implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(StudentRegistered $event): void
    {
        if ($event->user->email) {
            Mail::to($event->user->email)->send(
                new StudentCredentialsMail($event->user, $event->password)
            );
        }
    }
}