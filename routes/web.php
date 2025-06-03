<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admins\SSEController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admins\NoteController;
use App\Http\Controllers\Admins\RoleController;
use App\Http\Controllers\Admins\RoomController;
use App\Http\Controllers\Admins\TaskController;
use App\Http\Controllers\Admins\UserController;
use App\Http\Controllers\Admins\ReplyController;
use App\Http\Controllers\Admins\BranchController;
use App\Http\Controllers\Admins\TicketController;
use App\Http\Controllers\Admins\CategoryController;
use App\Http\Controllers\Admins\EmployeeController;
use App\Http\Controllers\Admins\PriorityController;
use App\Http\Controllers\Admins\StatusesController;
use App\Http\Controllers\Admins\DashboardController;
use App\Http\Controllers\Admins\IssueTypeController;
use App\Http\Controllers\Admins\DepartmentController;
use App\Http\Controllers\Admins\FixedAssetController;
use App\Http\Controllers\Admins\PermissionController;
use App\Http\Controllers\Admins\MaintenanceController;
use App\Http\Controllers\Admins\NotificationController;
use App\Http\Controllers\Admins\TicketReportController;
use App\Http\Controllers\Admins\ResponsesTicketController;
use App\Http\Controllers\Admins\TicketGuidelinesController;
use App\Http\Controllers\Admins\MaintenanceReportController;
use App\Http\Controllers\Admins\MaintenanceMissionController;
use App\Http\Controllers\Admins\PermissionCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/login/change/password', [LoginController::class, 'changePassword']);
// Route::get('/', function () {
//     // return view('layouts.admin');
//     return view('welcome');
// });

Auth::routes();
Route::group(['middleware'=>['auth:sanctum'], 'prefix'=>'admin'],function(){
    Route::get('/page/not-found', function() {
        return view('upgrade.feature_not_available');
    });
    Route::get('/reset/password', [UserController::class, 'formResetPassword']);
    Route::post('/reset/password', [UserController::class, 'resetPassword']);
    
    Route::get('/dashboad', [DashboardController::class,'index']);
    Route::get('/dashboad/show', [DashboardController::class,'show']);

    // users 
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/show', [UserController::class, 'show']);
    Route::get('/user/form-create', [UserController::class, 'create']);
    Route::get('/user/form-edit/{id}', [UserController::class, 'edit']);
    Route::post('/user/create', [UserController::class, 'store']);
    Route::post('/user/update', [UserController::class, 'update']);
    Route::post('/user/status', [UserController::class, 'updateStatus']);
    Route::post('/user/delete', [UserController::class, 'destroy']);
    Route::post('/user/online/delete', [UserController::class, 'userOnlineDelet']);
    Route::post('/user/duplicate', [UserController::class, 'duplicateUser']);
    Route::get('/user/profile/{id}', [UserController::class, 'userProfile']);
    Route::post('/user/profile/update', [UserController::class, 'userProfileUpdate']);

    // Ticket  
    Route::get('/ticket', [TicketController::class, 'index']);
    Route::get('/ticket/show', [TicketController::class, 'show']);
    Route::get('/ticket/create/{id}', [TicketController::class, 'create']);
    Route::get('/ticket/edit/{id}', [TicketController::class, 'edit']);
    Route::post('/ticket/save', [TicketController::class, 'store']);
    Route::post('/ticket/import', [TicketController::class, 'import']);
    Route::get('/ticket/detail/{trackid}', [TicketController::class, 'detail']);
    Route::post('/ticket/update', [TicketController::class, 'update']);
    Route::post('/ticket/update/status', [TicketController::class, 'status']);
    Route::post('/ticket/update/priority', [TicketController::class, 'priorities']);
    Route::post('/ticket/update/assignedto', [TicketController::class, 'assignedTo']);
    Route::get('/ticket/show-one', [TicketController::class, 'showOne']);
    Route::post('/ticket/replies', [TicketController::class, 'replies']);
    Route::post('/ticket/delete', [TicketController::class, 'destroy']);
    Route::get('/ticket/view-guidelines/{id}', [TicketController::class, 'viewGuidelines']);

    // Note  
    Route::get('/note/show', [NoteController::class, 'show']);
    Route::get('/note/create/{id}', [NoteController::class, 'create']);
    Route::post('/note/update', [NoteController::class, 'update']);
    Route::post('/note/save', [NoteController::class, 'store']);
    Route::post('/note/delete', [NoteController::class,'destroy']);

    // Replies  ticket
    Route::get('/replies/show', [ReplyController::class, 'show']);
    Route::get('/replies/create/{id}', [ReplyController::class, 'create']);
    Route::post('/replies/update', [ReplyController::class, 'update']);
    Route::post('/replies/save', [ReplyController::class, 'store']);
    Route::post('/replies/delete', [ReplyController::class,'destroy']);

    // Statuses
    Route::get('/statuses', [StatusesController::class, 'index']);
    Route::post('/statuses/store', [StatusesController::class,'store']);
    Route::post('/statuses/update', [StatusesController::class,'update']);
    Route::post('/statuses/delete', [StatusesController::class,'destroy']);

    // Department
    Route::get('/department', [DepartmentController::class, 'index']);
    Route::post('/department/store', [DepartmentController::class,'store']);
    Route::post('/department/update', [DepartmentController::class,'update']);
    Route::post('/department/delete', [DepartmentController::class,'destroy']);
    Route::post('/department/status', [DepartmentController::class,'onchangStatus']);

    // Branch
    Route::get('/branch', [BranchController::class, 'index']);
    Route::post('/branch/store', [BranchController::class,'store']);
    Route::get('/branch/edit', [BranchController::class,'edit']);
    Route::post('/branch/update', [BranchController::class,'update']);
    Route::post('/branch/delete', [BranchController::class,'destroy']);

    // Priority
    Route::resource('priority', PriorityController::class);

    //maintenance
    Route::resource('employee', EmployeeController::class);
    Route::resource('maintenance', MaintenanceController::class);
    Route::get('/serial', [MaintenanceController::class,'OnChangeSerial']);
    Route::get('/onchange/branch', [MaintenanceController::class,'OnChangeBranch']);
    Route::get('/onchange/department', [MaintenanceController::class,'OnChangeDepartment']);

    //maintenance mission
    Route::resource('mission', MaintenanceMissionController::class);

    //maintenance report
    Route::get('report/maintenance', [MaintenanceReportController::class, 'report']);
    Route::get('report/maintenance/export', [MaintenanceReportController::class, 'maintenanceExport']);
    Route::get('maintenance/history/{id}', [MaintenanceReportController::class, 'maintenanceHistory']);

    // Issue Type
    Route::get('/issue-type/duplicate', [IssueTypeController::class,'duplicateIssueType']);
    Route::get('/show/issue-type', [IssueTypeController::class,'showById']);
    Route::resource('issue-type', IssueTypeController::class);
    Route::post('/issue-type/ids', [IssueTypeController::class,'dataSelect']);
    Route::post('/issue-type/import', [IssueTypeController::class,'dataImport']);
    
    // Reports
    Route::resource('report/ticket', TicketReportController::class);
    Route::get('ticket/report/show', [TicketReportController::class,'show']);
    Route::post('ticket/report/search', [TicketReportController::class,'search']);
    Route::get('ticket/report/export', [TicketReportController::class,'export']);

    Route::resource('role', RoleController::class);
    Route::get('role/user/{id}', [RoleController::class, "userList"]);
    Route::resource('permission', PermissionController::class);
    Route::resource('permissions/category', PermissionCategoryController::class);
    Route::post('permissions/category/duplicate', [PermissionCategoryController::class, "duplicate"]);

    Route::get('ticket-guideline/edit', [TicketGuidelinesController::class, "edit"]);
    Route::post('ticket-guideline/update', [TicketGuidelinesController::class, "update"]);
    Route::resource('ticket-guideline', TicketGuidelinesController::class);

    Route::resource('ticket-responses', ResponsesTicketController::class);
    Route::resource('task', TaskController::class);
    Route::post('/task/import', [TaskController::class, 'import']);

    Route::resource('category', CategoryController::class);
    Route::post('/category/import', [CategoryController::class, 'import']);

    Route::resource('asset', FixedAssetController::class);
    Route::post('/asset/import', [FixedAssetController::class, 'import']);

    Route::resource('room', RoomController::class);
    Route::post('/room/import', [RoomController::class, 'roomImport']);

    // *** send notification **/
    Route::get('/notification', [NotificationController::class, 'index']);
    Route::get('/notification/totals', [NotificationController::class, 'totalNotification']);
    Route::post('/create-notification', [NotificationController::class, 'create']);
    Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead']);
    
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

