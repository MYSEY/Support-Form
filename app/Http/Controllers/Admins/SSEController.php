<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SSEController extends Controller
{
    public function sendSSE()
    {
        // Set headers for SSE
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');

        // Retrieve the first unsent notification
        $notify = notification::where("to_user_id", Auth::user()->id)->where("is_send", 0)
        ->leftJoin('tickets', 'notifications.ticket_id', '=', 'tickets.id')
        ->select(
            'notifications.*',
            'tickets.subject as ticket_subject',
            'tickets.message as ticket_message',
            'tickets.message_html as ticket_message_html',
            'tickets.department_id',
        )
        ->first();

        if ($notify) {
            // Prepare event data
            $eventData = [
                'message' => $notify->ticket_subject,
                'user_id' => $notify->to_user_id,
                'department_id' => $notify->department_id,
            ];

            // Send the event data as JSON
            echo "data: " . json_encode($eventData) . "\n\n";

            // Mark the notification as sent
            $notify->is_send = 1;
            $notify->save();
        } else {
            // Send an empty message to keep the connection alive
            echo ": keep-alive\n\n";
        }

        // Flush the output
        ob_flush();
        flush();
    }
}
