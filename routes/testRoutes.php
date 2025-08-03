<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

// Admin 
Route::get('/__test/routes', function () {
    if (!app()->environment('local')) {
        abort(403, 'Unauthorized');
    }

    // Dummy ID values for routes with parameters
    $dummyIds = [
        'sp_profile/{id}' => 'sp_profile/1',
        'sp_profile/delete/{id}' => 'sp_profile/delete/1',
        'dm_profile/{id}' => 'dm_profile/1',
        'dm_profile/delete/{id}' => 'dm_profile/delete/1',
        'admin/get-deliverymen/{supervisorId}' => 'admin/get-deliverymen/1',
        'sp_profile_update/{id}' => 'sp_profile_update/1',
        'dm_profile_update/{id}' => 'dm_profile_update/1',
    ];

    // Fetch GET routes with admin.auth and web middleware (excluding __test and logout)
    $getRoutes = collect(Route::getRoutes())
        ->filter(function ($route) {
            return in_array('admin.auth', $route->middleware())
                && in_array('web', $route->middleware())
                && in_array('GET', $route->methods())
                && !Str::contains($route->uri(), ['__test', 'logout']);
        })
        ->map(function ($route) use ($dummyIds) {
            $uri = $route->uri();
            return [
                'method' => 'GET',
                'uri' => '/' . ($dummyIds[$uri] ?? ltrim($uri, '/')),
            ];
        });

    // Manually add your POST routes here with dummy IDs replaced
    $postRoutes = collect([
        ['method' => 'POST', 'uri' => '/supervisor/store'],
        ['method' => 'POST', 'uri' => '/sp_profile_update/1'],
        ['method' => 'POST', 'uri' => '/delivery_man/store'],
        ['method' => 'POST', 'uri' => '/dm_profile_update/1'],
        ['method' => 'POST', 'uri' => '/delivery_team/tl_assign_to_sp_store'],
    ]);

    // Combine GET and POST routes, unique by method+uri to avoid duplicates
    $allRoutes = $getRoutes->merge($postRoutes)
        ->unique(function ($item) {
            return $item['method'] . $item['uri'];
        })
        ->values();

    return $allRoutes;
});



// Supervisor
Route::get('/__test/supervisor-routes', function () {
    if (!app()->environment('local')) {
        abort(403, 'Unauthorized');
    }

    $dummyIds = [
        'supervisor/profile_update' => 'supervisor/profile_update',
        'supervisor/tl_assign_to_dm_store' => 'supervisor/tl_assign_to_dm_store',
        'supervisor/delivery_process/verified_by_sp_store' => 'supervisor/delivery_process/verified_by_sp_store',
        'supervisor/delivery_process/delivery_slip_store' => 'supervisor/delivery_process/delivery_slip_store',
        'supervisor/delivery_process/call_store' => 'supervisor/delivery_process/call_store', 
    ];

    // Get all GET routes with supervisor.auth
    $getRoutes = collect(Route::getRoutes())
        ->filter(function ($route) {
            return in_array('supervisor.auth', $route->middleware())
                && in_array('web', $route->middleware())
                && in_array('GET', $route->methods())
                && !Str::contains($route->uri(), ['__test', 'logout']);
        })
        ->map(function ($route) use ($dummyIds) {
            $uri = $route->uri();
            // Replace any route parameters with dummy value "1"
            $resolvedUri = preg_replace('/\{[^}]+\}/', '1', $uri);
            return [
                'method' => 'GET',
                'uri' => '/' . ($dummyIds[$uri] ?? $resolvedUri),
            ];
        });

    // Add POST routes manually
    $postRoutes = collect([
        ['method' => 'POST', 'uri' => '/supervisor/profile_update'],
        ['method' => 'POST', 'uri' => '/supervisor/tl_assign_to_dm_store'],
        ['method' => 'POST', 'uri' => '/supervisor/delivery_process/verified_by_sp_store'],
        ['method' => 'POST', 'uri' => '/supervisor/delivery_process/delivery_slip_store'],
        ['method' => 'POST', 'uri' => '/supervisor/delivery_process/call_store'], // ✅ new
    ]);

    $allRoutes = $getRoutes->merge($postRoutes)
        ->unique(fn ($item) => $item['method'] . $item['uri'])
        ->values();

    return response()->json($allRoutes);
});



// Deliveryman
Route::get('/__test/deliveryman-routes', function () {
    if (!app()->environment('local')) {
        abort(403, 'Unauthorized');
    }

    // Map dynamic route parts with dummy values if needed
    $dummyIds = [
        'deliveryman/profile_update' => 'deliveryman/profile_update',
        'deliveryman/delivery_process/call_store' => 'deliveryman/delivery_process/call_store',
        'deliveryman/delivery_process/delivery_status_store' => 'deliveryman/delivery_process/delivery_status_store',
        'deliveryman/delivery_process/sendOtp' => 'deliveryman/delivery_process/sendOtp',
        'deliveryman/delivery_process/verifyOtp' => 'deliveryman/delivery_process/verifyOtp',
        'deliveryman/delivery_process/delivered_store' => 'deliveryman/delivery_process/delivered_store',
        'deliveryman/returned_store' => 'deliveryman/returned_store',
        'deliveryman/update-password' => 'deliveryman/update-password',
    ];

    // Automatically detect GET routes protected by 'auth' middleware
    $getRoutes = collect(Route::getRoutes())
        ->filter(function ($route) {
            return in_array('auth', $route->middleware())
                && in_array('web', $route->middleware())
                && in_array('GET', $route->methods())
                && Str::startsWith($route->uri(), 'deliveryman/')
                && !Str::contains($route->uri(), ['__test', 'logout']);
        })
        ->map(function ($route) use ($dummyIds) {
            $uri = $route->uri();
            $resolvedUri = preg_replace('/\{[^}]+\}/', '1', $uri);
            return [
                'method' => 'GET',
                'uri' => '/' . ($dummyIds[$uri] ?? $resolvedUri),
            ];
        });

    // Add POST routes manually
    $postRoutes = collect([
        ['method' => 'POST', 'uri' => '/deliveryman/profile_update'],
        ['method' => 'POST', 'uri' => '/deliveryman/delivery_process/call_store'],
        ['method' => 'POST', 'uri' => '/deliveryman/delivery_process/delivery_status_store'],
        ['method' => 'POST', 'uri' => '/deliveryman/delivery_process/sendOtp'],
        ['method' => 'POST', 'uri' => '/deliveryman/delivery_process/verifyOtp'],
        ['method' => 'POST', 'uri' => '/deliveryman/delivery_process/delivered_store'],
        ['method' => 'POST', 'uri' => '/deliveryman/returned_store'],
        ['method' => 'POST', 'uri' => '/deliveryman/update-password'],
    ]);

    // Merge GET + POST routes, avoid duplicates
    $allRoutes = $getRoutes->merge($postRoutes)
        ->unique(fn ($item) => $item['method'] . $item['uri'])
        ->values();

    return response()->json($allRoutes);
});