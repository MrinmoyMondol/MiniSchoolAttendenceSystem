<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\AttendanceRecorded;
use Illuminate\Support\Facades\Log;

class SendAttendanceNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
   public function handle(AttendanceRecorded $event)
    {
        // Example: log or notify teachers/parents via mail/push
        // For demonstration, we'll just log a summary
        $count = count($event->records);
        Log::info("AttendanceRecorded: {$count} items recorded.");
        // Real implementation: dispatch mail notifications, push notifications etc.
    }
}
