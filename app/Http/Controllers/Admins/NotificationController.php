<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\CustomStatus;
use App\Models\notification;
use App\Models\NotificationUserRead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;
use Pusher\Pusher;

class NotificationController extends Controller
{

    public function index() {
        $roleName = Auth::user()->RolePermission;
        $departmentId = Auth::user()->department_id;
        $userId = Auth::user()->id;
        $dataNotify = notification::where('notifications.is_send', 1)
        ->leftJoin('users as from_users', 'notifications.from_user_id', '=', 'from_users.id')
        ->leftJoin('users as to_users', 'notifications.to_user_id', '=', 'to_users.id')
        ->leftJoin('tickets', 'notifications.ticket_id', '=', 'tickets.id')
        ->leftJoin('users as create_by', 'tickets.created_by', '=', 'create_by.id')
        ->leftJoin('departments', 'tickets.department_id_from', '=', 'departments.id')
        ->leftJoin('branchs', 'tickets.branch_id', '=', 'branchs.id')
        ->select(
            'notifications.*',
            'from_users.id as from_user_id',
            'from_users.name as from_user_name',
            'from_users.email as from_user_email',
            'from_users.profile as from_user_profile',
            'to_users.id as to_user_id',
            'to_users.name as to_user_name',
            'to_users.email as to_user_email',
            'tickets.subject as ticket_subject',
            'create_by.name as ticket_by',
            'tickets.message as ticket_message',
            'tickets.message_html as ticket_message_html',
            'tickets.department_id_from',
            'tickets.department_id',
            'tickets.status as ticket_status',
            'departments.name_khmer',
            'departments.name_english',
            'branchs.branch_name_kh',
            'branchs.branch_name_en',
        )
        ->when($departmentId, function ($query, $department_id) use ($roleName, $userId){
            if ($roleName == "admin_support" || $roleName == "admin" || $roleName == "super_admin") {
                $query->where("tickets.department_id", $department_id);
                $query->where("notifications.to_user_id", "unassigned");
                $query->orWhere("notifications.to_user_id", $userId);
            }else {
                $query->where("notifications.to_user_id", $userId);
            }
        })
        ->orderBy('notifications.created_at','desc')->get();
        return response()->json([
            'notifications' => $dataNotify
        ]);
    }

    public function totalNotification(Request $request){
        $roleName = Auth::user()->RolePermission;
        $userId = Auth::user()->id;
        $UserRead = NotificationUserRead::where("user_id", $userId)->count();
        $dataNotify = notification::where('notifications.is_send', 1)
        ->leftJoin('tickets', 'notifications.ticket_id', '=', 'tickets.id')
        ->select(
            'notifications.*',
            'tickets.department_id_from',
            'tickets.department_id',
        )
        ->when($request->department_id, function ($query, $department_id) use ($roleName, $userId){
            if ($roleName == "admin_support" || $roleName == "admin" || $roleName == "super_admin") {
                $query->where("tickets.department_id", $department_id);
                $query->where("notifications.to_user_id", "unassigned");
                $query->orWhere("notifications.to_user_id", $userId);
            }else {
                $query->where("notifications.to_user_id", $userId);
            }
            
        })->count();
        return response()->json([
            'TotalNew' => ($dataNotify - $UserRead),
        ]);
    }
    
    public function create($request){
        $item = new notification();
        $item->from_user_id = $request["from_user_id"];
        $item->to_user_id = $request["to_user_id"];
        $item->ticket_id = $request["ticket_id"];
        $item->is_send = $request["is_send"];
        $item->message = $request["message"];
        $item->status = $request["status"];
        $item->save();
        $this->sendNotification($item);
    }

    private function sendNotification($nt)
    {
        $options = [
            'cluster' => 'mt1',
            'useTLS' => false
        ];

        $pusher = new Pusher(
            "01aab6a7bc64ae90cc82",
            "3fc9ba26c53b0c0d7146",
            "1924769",
            $options
        );

        $dataNotify = notification::where('notifications.id', $nt->id)
        ->leftJoin('users as from_users', 'notifications.from_user_id', '=', 'from_users.id')
        ->leftJoin('users as to_users', 'notifications.to_user_id', '=', 'to_users.id')
        ->leftJoin('tickets', 'notifications.ticket_id', '=', 'tickets.id')
        ->leftJoin('departments', 'tickets.department_id_from', '=', 'departments.id')
        ->leftJoin('branchs', 'tickets.branch_id', '=', 'branchs.id')
        ->select(
            'notifications.*',
            'notifications.status as notify_status',
            'from_users.id as from_user_id',
            'from_users.name as from_user_name',
            'from_users.email as from_user_email',
            'from_users.profile as from_user_profile',
            'to_users.id as to_user_id',
            'to_users.name as to_user_name',
            'to_users.email as to_user_email',
            'tickets.subject as ticket_subject',
            'tickets.message as ticket_message',
            'tickets.message_html as ticket_message_html',
            'tickets.department_id',
            'tickets.department_id_from',
            'departments.name_khmer as department_name_khmer',
            'departments.name_english as department_name_english',
            'branchs.branch_name_kh',
            'branchs.branch_name_en',
        )->first();
        $data = [
            'status'                    => $dataNotify->notify_status,
            'from_user_id'              => $dataNotify->from_user_id,
            'from_user_name'            => $dataNotify->from_user_name,
            'from_user_email'           => $dataNotify->from_user_email,
            'from_user_profile'         => $dataNotify->from_user_profile,
            'to_user_id'                => $dataNotify->to_user_id,
            'to_user_name'              => $dataNotify->to_user_name,
            'to_user_email'             => $dataNotify->to_user_email,
            'ticket_subject'            => $dataNotify->ticket_subject,
            'ticket_message'            => $dataNotify->ticket_message,
            'ticket_message_html'       => $dataNotify->ticket_message_html,
            'department_id'             => $dataNotify->department_id,
            'department_id_from'        => $dataNotify->department_id_from,
            'department_name_khmer'     => $dataNotify->department_name_khmer,
            'department_name_english'   => $dataNotify->department_name_english,
            'branch_name_kh'            => $dataNotify->branch_name_kh,
            'branch_name_en'            => $dataNotify->branch_name_en,
        ];

        // $info = $pusher->getChannelInfo('presence-channel-name', ['info' => 'user_count']);
        // $channelInfo = $pusher->get('/channels/presence-access-today');
        // $data = json_decode($channelInfo);
        // dd("Active connections:", $data);

        $pusher->trigger('my-channel', 'my-event', $data);
    }

    public function markAsRead(Request $request)
    {
        $ids = $request->input('ids'); // Array of notification IDs
        $userId = Auth::user()->id;
        if ($ids && is_array($ids)) {
            foreach ($ids as $id) {
                NotificationUserRead::updateOrCreate(
                    ['notification_id' => $id, 'user_id' => $userId],
                    ['notification_id' => $id, 'user_id' => $userId]
                );
            }
        }
        return response()->json(['message' => 'Notifications marked as read.']);
    }
}
