<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DeliveryManController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\OtpController;
use Illuminate\Support\Str;

// Route::get('/', function () {
//     return view('welcome');
// });


// Admin Route starts from here

Route::group(['middleware' => 'admin.guest'], function () {
    Route::get('/', [AdminController::class, 'login'])->name('admin.login');

    Route::get('/register', [AdminController::class, 'register'])->name('admin.register');
    // Route::get('/admin_login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('admin_login', [AdminController::class, 'authenticate'])->name('admin.authenticate');

});


Route::group(['middleware' => 'admin.auth'], function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/upload', [AdminController::class, 'uploadexcel'])->name('admin.uploadexcel');
    Route::get('logout', [AdminController::class, 'logout'])->name('admin.logout');

    Route::get('/supervisor_add', [AdminController::class, 'add_supervisor'])->name('add.supervisor');
    Route::post('/supervisor/store', [AdminController::class, 'supervisor_store'])->name('supervisor.store');
    Route::get('/supervisor', [AdminController::class, 'all_supervisor'])->name('all.supervisor');
    Route::get('/sp_profile/{id}', [AdminController::class, 'sp_profile'])->name('admin.sp_profile');
    Route::post('/sp_profile_update/{id}', [AdminController::class, 'sp_profile_update'])->name('admin.sp_profile_update');
    Route::get('/sp_profile/delete/{id}', [AdminController::class, 'sp_profile_delete'])->name('admin.sp_profile_delete');

    Route::get('/delivery_man_add', [AdminController::class, 'add_delivery_man'])->name('add.delivery_man');
    Route::post('/delivery_man/store', [AdminController::class, 'delivery_man_store'])->name('delivery_man.store');
    Route::get('/delivery_man', [AdminController::class, 'all_delivery_man'])->name('all.delivery_man');
    Route::get('/dm_profile/{id}', [AdminController::class, 'dm_profile'])->name('admin.dm_profile');
    Route::post('/dm_profile_update/{id}', [AdminController::class, 'dm_profile_update'])->name('admin.dm_profile_update');
    Route::get('/dm_profile/delete/{id}', [AdminController::class, 'dm_profile_delete'])->name('admin.dm_profile_delete');

    Route::get('/print_all', [AdminController::class, 'print_all'])->name('print_all');
    Route::get('/print_with_number', [AdminController::class, 'print_with_number'])->name('print_with_number');
    Route::get('/print_without_number', [AdminController::class, 'print_without_number'])->name('print_without_number');

    Route::get('/delivery_team/tl_assign_to_sp', [AdminController::class, 'tl_assign_to_sp'])->name('tl_assign_to_sp');
    Route::post('/delivery_team/tl_assign_to_sp_store', [AdminController::class, 'tl_assign_to_sp_store'])->name('tl_assign_to_sp_store');
    Route::get('/delivery_team/get-zones', [AdminController::class, 'getZonesForSupervisor'])->name('zones.get');
    Route::get('/delivery_team/supervisor_details', [AdminController::class, 'supervisor_details'])->name('supervisor_details');
    // Route::get('/delivery_team/supervisor_filter', [AdminController::class, 'supervisor_filter'])->name('supervisor_filter');
    Route::get('/delivery_team/delivery_man_details', [AdminController::class, 'delivery_man_details'])->name('delivery_man_details');
    Route::get('/admin/get-deliverymen/{supervisorId}', [AdminController::class, 'getDeliverymenBySupervisorZone']);


    Route::get('/delivery_process/call_verification', [AdminController::class, 'call_verification'])->name('call_verification');
    Route::get('/delivery_process/delivery_status', [AdminController::class, 'delivery_status'])->name('delivery_status');
    Route::get('/delivery_process/verified_by_sp', [AdminController::class, 'verified_by_sp'])->name('verified_by_sp');
    Route::get('/delivery_process/delivered', [AdminController::class, 'delivered'])->name('delivered');

    Route::get('/delivery_report', [AdminController::class, 'delivery_report'])->name('delivery_report');

    Route::get('/return_to_dncc', [AdminController::class, 'dncc_return'])->name('admin.return');
    Route::get('/map', [AdminController::class, 'showTradeMap'])->name('admin.map');
    Route::get('/otp_verification', [AdminController::class, 'otp_verification'])->name('admin.otp_verification');

});

// Admin Route ends here

include __DIR__ . '../testRoutes.php';

// Supervisor Route starts from here

Route::group(['prefix' => 'supervisor'], function () {

    Route::group(['middleware' => 'supervisor.guest'], function () {

        Route::get('login', [SupervisorController::class, 'login'])->name('supervisor.login');
        Route::post('login', [SupervisorController::class, 'authenticate'])->name('supervisor.authenticate');
        Route::get('otp-verify', [SupervisorController::class, 'showOtpForm'])->name('supervisor.otp.verify.form');
        Route::post('otp-verify', [SupervisorController::class, 'verifyOtp'])->name('supervisor.otp.verify');
    });


    Route::group(['middleware' => 'supervisor.auth'], function () {

        Route::get('dashboard',[SupervisorController::class,'dashboard'])->name('supervisor.dashboard');

        Route::get('profile', [SupervisorController::class,'profile'])->name('supervisor.profile');

        Route::post('profile_update', [SupervisorController::class,'profile_update'])->name('supervisor.profile_update');

        Route::get('assignedTL', [SupervisorController::class,'assignedTL'])->name('supervisor.assignedTL');

        Route::get('tl_assign_to_dm', [SupervisorController::class,'tl_assign_to_dm'])->name('supervisor.tl_assign_to_dm');

        Route::post('tl_assign_to_dm_store', [SupervisorController::class,'tl_assign_to_dm_store'])->name('supervisor.tl_assign_to_dm_store');

        Route::get('delivery_process/call_verification', [SupervisorController::class,'call_verification'])->name('supervisor.call_verification');

        Route::post('delivery_process/call_store', [SupervisorController::class,'call_store'])->name('supervisor.call_store');

        Route::get('delivery_process/delivery_status', [SupervisorController::class,'delivery_status'])->name('supervisor.delivery_status');

        Route::get('delivery_process/verified_by_sp', [SupervisorController::class,'verified_by_sp'])->name('supervisor.verified_by_sp');

        Route::post('delivery_process/verified_by_sp_store', [SupervisorController::class,'verified_by_sp_store'])->name('supervisor.verified_by_sp_store');

        Route::get('delivery_process/delivered', [SupervisorController::class,'delivered'])->name('supervisor.delivered');

        // Route::post('delivery_process/delivered_store', [SupervisorController::class,'delivered_store'])->name('supervisor.delivered_store');
        Route::get('delivery_process/delivery_slip', [SupervisorController::class,'delivery_slip'])->name('supervisor.approve_delivery_slip');

        Route::post('delivery_process/delivery_slip_store', [SupervisorController::class,'delivery_slip_store'])->name('supervisor.approve_delivery_slip_store');

        Route::get('delivery_report', [SupervisorController::class,'delivery_report'])->name('supervisor.delivery_report');

        Route::get('return', [SupervisorController::class,'return_to_dncc'])->name('supervisor.return');

        Route::get('logout',[SupervisorController::class,'logout'])->name('supervisor.logout');


    });
});

// Supervisor Route ends here

include __DIR__ . '../testRoutes.php';


// Delivery Man Route starts from here

Route::group(['prefix' => 'deliveryman'], function () {

    Route::group(['middleware' => 'guest'],function(){

    Route::get('login', [DeliveryManController::class,'login'])->name('deliveryman.login');
    Route::post('authenticate', [DeliveryManController::class,'authenticate'])->name('deliveryman.authenticate');
    Route::get('otp-verify', [DeliveryManController::class, 'showOtpForm'])->name('deliveryman.otp.verify.form');
    Route::post('otp-verify', [DeliveryManController::class, 'verifyOtp'])->name('deliveryman.otp.verify');

    });


    Route::group(['middleware' => 'auth'],function(){

    Route::get('dashboard', [DeliveryManController::class,'dashboard'])->name('deliveryman.dashboard');
    Route::get('profile', [DeliveryManController::class,'profile'])->name('deliveryman.profile');
    Route::post('profile_update', [DeliveryManController::class,'profile_update'])->name('deliveryman.profile_update');
    Route::get('assignedTL', [DeliveryManController::class,'assignedTL'])->name('deliveryman.assignedTL');

    Route::get('delivery_process/call_verification', [DeliveryManController::class,'call_verification'])->name('deliveryman.call_verification');

    Route::post('delivery_process/call_store', [DeliveryManController::class,'call_store'])->name('deliveryman.call_store');

    Route::get('delivery_process/delivery_status', [DeliveryManController::class,'delivery_status'])->name('deliveryman.delivery_status');

    Route::post('delivery_process/delivery_status_store', [DeliveryManController::class,'delivery_status_store'])->name('deliveryman.delivery_status_store');

    Route::get('delivery_process/send_otp', [DeliveryManController::class,'send_otp'])->name('deliveryman.send_otp');

    Route::post('delivery_process/sendOtp', [OtpController::class,'sendOtp'])->name('deliveryman.sendOtp');

    Route::get('delivery_process/verify_otp', [DeliveryManController::class,'verify_otp'])->name('deliveryman.verify_otp');

    Route::post('delivery_process/verifyOtp', [OtpController::class,'verifyOtp'])->name('deliveryman.verifyOtp');

    Route::get('delivery_process/delivered', [DeliveryManController::class,'delivered'])->name('deliveryman.delivered');

    Route::post('delivery_process/delivered_store', [DeliveryManController::class,'delivered_store'])->name('deliveryman.delivered_store');

    Route::get('return_to_dncc', [DeliveryManController::class,'return'])->name('deliveryman.return');

    Route::post('returned_store', [DeliveryManController::class,'returned_store'])->name('deliveryman.returned_store');

    Route::get('logout', [DeliveryManController::class,'logout'])->name('deliveryman.logout');

    Route::get('change-password', [DeliveryManController::class,'ChangePassword'])->name('deliveryman.changePassword');
    
    Route::post('update-password', [DeliveryManController::class,'UpdatePassword'])->name('deliveryman.updatePassword');

    });

});

// Delivery Man Route ends here

include __DIR__ . '../testRoutes.php';
