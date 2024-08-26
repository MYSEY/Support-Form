<?php

use App\Helpers\Helper;
use App\Models\PermissionCategory;
use Illuminate\Support\Facades\Auth;

function RolePermission($controller, $name)
{
    $role = PermissionCategory::where("name", $name)->first();
    if ($role) {
        $permissions = $role->getPermissions();
        foreach ($permissions as $permission) {
            $middlewareName = 'permission:' . $permission->name;
            $only = [];

            if ($permission->name === $name." View") {
                $only[] = 'index';
            } 
            if ($permission->name === $name." Create") {
                $only[] = 'create';
                $only[] = 'store';
            }
            if ($permission->name === $name." Edit") {
                $only[] = 'update';
                $only[] = 'edit';
            }
            if ($permission->name === $name." Delete") {
                $only[] = 'destroy';
            }

            if (!empty($only)) {
                $controller->middleware($middlewareName, ['only' => $only]);
            }
        }
    }else {
        $controller->middleware('permission:' . $name. 'View', ['only' => []]);
    }
}
function userHasAnyPermission(array $permissions)
{
    $user = Auth::user();
    if (!$user) {
        return false;
    }
    foreach ($permissions as $permission) {
        if ($user->can($permission)) {
            return true;
        }
    }
    return false;
}