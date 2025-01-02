<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\CustomStatus;
use App\Models\notification;
use App\Models\NotificationUserRead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'tickets.status',
            'departments.name_khmer',
            'departments.name_english',
            'branchs.branch_name_kh',
            'branchs.branch_name_en',
        )
        ->when($departmentId, function ($query, $department_id) use ($roleName, $userId){
            $query->where("tickets.department_id", $department_id);
            if ($roleName == "admin_support" || $roleName == "admin" || $roleName == "super_admin") {
                $query->where("notifications.to_user_id", "unassigned");
                $query->orWhere("notifications.to_user_id", $userId);
            }else {
                $query->where("notifications.to_user_id", $userId);
            }
        })
        ->orderBy('notifications.created_at','desc')->take(20)->get();
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
            $query->where("tickets.department_id", $department_id);
            if ($roleName == "admin_support" || $roleName == "admin") {
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
    
    public function create(Request $request){
        $user_id = Auth::user()->id;
        $item = new notification();
        $item->message = $request->message;
        $item->from_user_id = $user_id;
        $item->to_user_id = $request->to_user_id;
        $item->ticket_id = $request->ticket_id;
        $item->is_send = 0;
        $item->save();

        return response()->json('Add successfully');
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
