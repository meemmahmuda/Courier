<?php

namespace App\Http\Controllers;

use App\Models\TradeLicence;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Otp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class AdminController extends Controller
{
    public function dashboard()
    {
        $data['total_printed'] = TradeLicence::all()->count();
        $data['with_number'] = TradeLicence::where('Mob', '!=', null)->count();
        $data['without_number'] = TradeLicence::where('Mob', null)->count();
        $data['number_of_supervisor'] = User::where('role', 'supervisor')->count();
        $data['number_of_delivery_man'] = User::where('role', 'deliveryman')->count();
        $data['delivered'] = TradeLicence::where('delivery_status', 'Delivered')->count();
        $data['cancelled'] = TradeLicence::where('delivery_status', 'Cancelled')->count();
        $data['returned'] = TradeLicence::where('delivery_status', 'Returned')->count();
        return view('admin.dashboard', $data);
    }

    public function uploadExcel(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls',
        ]);

        $path = $request->file('excel_file')->getRealPath();
        $data = Excel::toArray([], $request->file('excel_file'));

        if (empty($data) || count($data[0]) == 0) {
            return back()->with('success', 'Excel file is empty.');
        }

        $rows = $data[0]; // Get the first sheet
        $header = array_map('trim', $rows[0]); // First row is the header

        // Mapping Excel headers to DB columns
        $columnMapping = [
            'Ref. No' => 'ref_no',
            'cdate' => 'cdate',
            'Gateway' => 'Gateway',
            'zonename' => 'zonename',
            'businame' => 'businame',
            'OwnerName' => 'OwnerName',
            'Mob' => 'Mob',
            'busiadd' => 'busiadd',
            'TLNumber' => 'TLNumber',
            'TL Page' => 'tl_page',
            'Print Code' => 'print_code',
            'UV Code' => 'uv_code',
            'PaymentType' => 'PaymentType',
            'busitype' => 'busitype',
            'bookvalue' => 'bookvalue',
            'product_type' => 'product_type',
        ];

        unset($rows[0]); // Remove the header row

        foreach ($rows as $row) {
    $row = array_combine($header, $row);

    // Check if the ref_no already exists
    $exists = TradeLicence::where('ref_no', $row['Ref. No'])->exists();
    if ($exists) {
        continue; // Skip existing records
    }

    $insertData = [];

    foreach ($columnMapping as $excelColumn => $dbColumn) {
        $value = $row[$excelColumn] ?? null;

        // Handle Excel date serial number conversion for 'cdate'
        if ($excelColumn === 'cdate') {
            if (is_numeric($value)) {
                $value = Carbon::instance(Date::excelToDateTimeObject($value))->format('d-m-Y');
            } else {
                // In case it's a string date (like '03/05/2025')
                $value = Carbon::parse($value)->format('d-m-Y');
            }
        }

        $insertData[$dbColumn] = $value;
    }

    TradeLicence::create($insertData);
}


        return back()->with('success', 'Excel file imported successfully.');
    }



    public function login()
    {
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            if (Auth::guard('admin')->user()->role != 'admin') {
                Auth::guard('admin')->logout();
                return redirect()->route('admin.login')->with('error', 'Access denied ! Unauthorised user.');
            }
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('admin.login')->with('error', 'Something went wrong');
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success', 'Logged out successfully');
    }

    public function all_supervisor()
    {
        $data['supervisors'] =  User::where('role', 'supervisor')->get();
        return view('admin.all_supervisor', $data);
    }

    public function  sp_profile($id)
    {
        $data['supervisors'] = User::find($id);
        $data['total_delivered'] = TradeLicence::where('assigned_sp', $id)->where('delivery_status','Delivered')->count();
        return view('admin.sp_profile', $data);
    }

    public function sp_profile_update(Request $request,$id)
    {
        $user = User::find($id);

        $request->validate([
            'status' => 'nullable',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'nid' => 'nullable|unique:users,nid',
            'zone' => 'nullable',

            'password' => 'nullable|min:6', // optional with confirmation
            'mobile' => [
                'nullable',
                'digits:11',
                'numeric',
                Rule::unique('users', 'mobile')->ignore(Auth::id()),
            ],
            'address'  => 'nullable|string|max:255',
        ], [
            'password.min' => 'Password must be at least 6 characters.',
            'email.unique' => 'Email already exist!',
            'nid.unique' => 'NID already exist!',
            'mobile.unique' => 'Mobile number already exist!',
            'mobile.digits' => 'Mobile number must be exactly 11 digits.',
        ]);

        $data = [];

        if ($request->filled('status')) {
            $data['status'] = $request->status;
        }

        if ($request->filled('name')) {
            $data['name'] = $request->name;
        }

        if ($request->filled('email')) {
            $data['email'] = $request->email;
        }

        if ($request->filled('nid')) {
            $data['nid'] = $request->nid;
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->filled('mobile')) {
            $data['mobile'] = $request->mobile;
        }

        if ($request->filled('address')) {
            $data['address'] = $request->address;
        }

        if ($request->filled('zone')) {
            $data['zone'] = implode(', ', $request->zone); // Convert array to comma-separated string
        }


        if ($request->hasFile('image')) {

            $request->validate([
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            // Delete old profile picture if exists
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }

            $data['image'] = $request->file('image')->store('profiles', 'public');
        }

        $user->update($data);

        return redirect()->route('admin.sp_profile',$id)->with('success', 'Profile updated successfully.');
    }

    public function sp_profile_delete($id)
    {
        $data = User::find($id);
        $data->delete();

        return redirect()->back()->with('success', 'Supervisor deleted successfully.');
    }

    public function add_supervisor()
    {
        $data['for_zone_check'] = User::where('role', 'supervisor')->get();
        return view('admin.add_supervisor', $data);
    }

    public function supervisor_store(Request $request)
    {
        $request->validate([

            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'mobile' => 'required|unique:users,mobile',
            'nid' => 'required|unique:users,nid',
            'zone' => 'required',
        ], [
            'email.unique' => 'Email already exists.',
            'mobile.unique' => 'Mobile already exists.',
            'nid.unique' => 'NID already exists.',

        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->dob = $request->dob;
        $user->mobile = $request->mobile;
        $user->nid = $request->nid;
        $zoneString = implode(', ', $request->zone); // Convert array to comma-separated string
        $user->zone = $zoneString;
        $user->role = 'supervisor';
        $user->status = 'active';
        $user->address = '';
        $user->image = '';

        $user->save();

        return redirect()->route('add.supervisor')->with(
            'success',
            'Supervisor added successfully.'
        );
    }

    public function all_delivery_man()
    {
        $data['deliveryman'] =  User::where('role', 'deliveryman')->get();
        return view('admin.all_delivery_man', $data);
    }

    public function dm_profile($id)
    {
        $data['supervisor_name'] = User::where('role', 'supervisor')->where('status', 'active')->get();
        $data['dm_profile'] = User::find($id);
        $data['total_delivered'] = TradeLicence::where('assigned_dm', $id)->where('delivery_status','Delivered')->count();
        return view('admin.dm_profile', $data);
    }


    public function dm_profile_update(Request $request,$id)
    {
        $user = User::find($id);

        $request->validate([
            'status' => 'nullable',
            'zone' => 'nullable',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'nid' => 'nullable|unique:users,nid',

            'password' => 'nullable|min:6', // optional with confirmation
            'mobile' => [
                'nullable',
                'digits:11',
                'numeric',
                Rule::unique('users', 'mobile')->ignore(Auth::id()),
            ],
            'address'  => 'nullable|string|max:255',
        ], [
            'password.min' => 'Password must be at least 6 characters.',
            'email.unique' => 'Email already exist!',
            'nid.unique' => 'NID already exist!',
            'mobile.unique' => 'Mobile number is already exist!',
            'mobile.digits' => 'Mobile number must be exactly 11 digits.',
        ]);

        $data = [];

        if ($request->filled('status')) {
            $data['status'] = $request->status;
        }

        if ($request->filled('zone')) {
            $data['zone'] = $request->zone;
        }

        if ($request->filled('name')) {
            $data['name'] = $request->name;
        }

        if ($request->filled('email')) {
            $data['email'] = $request->email;
        }

        if ($request->filled('nid')) {
            $data['nid'] = $request->nid;
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->filled('mobile')) {
            $data['mobile'] = $request->mobile;
        }

        if ($request->filled('address')) {
            $data['address'] = $request->address;
        }



        if ($request->hasFile('image')) {

            $request->validate([
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            // Delete old profile picture if exists
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }

            $data['image'] = $request->file('image')->store('profiles', 'public');
        }

        $user->update($data);

        return redirect()->route('admin.dm_profile',$id)->with('success', 'Profile updated successfully.');
    }

    public function dm_profile_delete($id)
    {
        $data = User::find($id);
        $data->delete();

        return redirect()->back()->with('success', 'Delivery Man deleted successfully.');
    }

    public function add_delivery_man()
    {
        $data['select_supervisors'] = User::where('role', 'supervisor')->where('status', 'active')->get();
        return view('admin.add_delivery_man', $data);
    }

    public function delivery_man_store(Request $request)
    {
        $request->validate([

            'supervisor' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'mobile' => 'required|unique:users,mobile',
            'nid' => 'required|unique:users,nid',
        ], [
            'email.unique' => 'Email already exists.',
            'mobile.unique' => 'Mobile already exists.',
            'nid.unique' => 'NID already exists.',

        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->dob = $request->dob;
        $user->mobile = $request->mobile;
        $user->nid = $request->nid;
        $user->zone = $request->supervisor;
        $user->role = 'deliveryman';
        $user->status = 'active';
        $user->address = '';
        $user->image = '';

        $user->save();

        return redirect()->route('add.delivery_man')->with(
            'success',
            'Delivery Man added successfully.'
        );
    }

    public function register()
    {
        $user = new User();
        $user->name = 'admin';
        $user->email = 'admin@gmail.com';
        $user->password = Hash::make('111');
        $user->dob = '1992-12-12';
        $user->mobile = '01712345678';
        $user->nid = '1234567891';
        $user->zone = 1;
        $user->role = 'admin';
        $user->status = 'active';
        $user->address = '';
        $user->image = '';

        $user->save();

        return redirect()->back()->with(
            'success',
            'Admin added successfully.'
        );
    }

    public function print_all(Request $request)
    {
        $query = TradeLicence::query();

        if ($request->filled('zonename')) {
        $query->where('zonename', $request->zonename);
    }

    if ($request->filled('product_type')) {
        $query->where('product_type', $request->product_type);
    }

    $data['print'] = $query->get();

    // Optional: for repopulating dropdowns in the form
    $data['zones'] = TradeLicence::distinct()->pluck('zonename');
    $data['productTypes'] = TradeLicence::distinct()->pluck('product_type');

        // else{
        //     $data['print'] = TradeLicence::all();
        // }


        return view('admin.print_all', $data);
    }

    public function print_with_number(Request $request)
    {
        $query = TradeLicence::query();
        if ($request->filled('zonename')) {
        $query->where('zonename', $request->zonename);
    }

    if ($request->filled('product_type')) {
        $query->where('product_type', $request->product_type);
    }

    $data['print_with_number'] = $query->get();

    // Optional: for repopulating dropdowns in the form
    $data['zones'] = TradeLicence::distinct()->pluck('zonename');
    $data['productTypes'] = TradeLicence::distinct()->pluck('product_type');

        return view('admin.print_with_number', $data);
    }

    public function print_without_number(Request $request)
    {
        $query = TradeLicence::query();
        if ($request->filled('zonename')) {
        $query->where('zonename', $request->zonename);
    }

    if ($request->filled('product_type')) {
        $query->where('product_type', $request->product_type);
    }

    $data['print_without_number'] = $query->whereNull('Mob')->get();

    // Optional: for repopulating dropdowns in the form
    $data['zones'] = TradeLicence::distinct()->pluck('zonename');
    $data['productTypes'] = TradeLicence::distinct()->pluck('product_type');


        return view('admin.print_without_number', $data);
    }

    public function tl_assign_to_sp()
    {
        $data['supervisors'] = User::where('role', 'supervisor')->where('status', 'active')->get();
        $data['assign_to_sp'] = TradeLicence::where('assigned_sp', null)->get();
        return view('admin.tl_assign_to_sp', $data);
    }

    public function tl_assign_to_sp_store(Request $request)
    {
        $request->validate([
            'supervisor' => 'required',
            'zonename' => 'required',
            'assigned_sp_date' => 'required',

        ]);


        $zone = TradeLicence::where('zonename', $request->zonename)->count();

        if ($zone === 0) {
            return redirect()->back()->with('error', "Zone $request->zonename doesn't exist in the record.");
        }

        // Check if there are any unassigned entries to update
        $unassignedExists = TradeLicence::where('zonename', $request->zonename)
            ->whereNull('assigned_sp')
            ->whereNull('delivery_status')
            ->exists();

        if (!$unassignedExists) {
            return redirect()->back()->with('error', "No unassigned records found for zone {$request->zonename}.");
        }

        // Update only unassigned records
        TradeLicence::where('zonename', $request->zonename)
            ->whereNull('assigned_sp')
            ->whereNull('delivery_status')
            ->update([
                'assigned_sp' => $request->supervisor,
                'assigned_sp_date' => $request->assigned_sp_date,
                'delivery_status' => "Assigned to SP"
            ]);

        return redirect()->back()->with('success', 'TL assigned to Supervisor successfully.');
    }

    public function getZonesForSupervisor(Request $request)
    {
        $supervisor = $request->supervisor;

        $user = DB::table('users')->where('id', $supervisor)->first();

        if ($user && $user->zone) {
            $zones = explode(',', $user->zone);
            return response()->json($zones);
        }

        return response()->json([]);
    }

    public function supervisor_details(Request $request)
    {
        $query = TradeLicence::with('supervisor');
        if ($request->supervisor) {
            $query->where('assigned_sp', $request->supervisor)
                ->whereNotIn('delivery_status', ['Delivered', 'Returned']);
            $data['assign_to_sp'] = $query->get();
        } else {
            $data['assign_to_sp'] = TradeLicence::where('assigned_sp', '!=', null)
                ->whereIn('delivery_status', ['Assigned to SP', 'Assigned to DM', 'Processing', 'Out for Delivery', 'Hold', 'Cancelled'])->get();
        }

        $data['select_supervisors'] = User::where('role', 'supervisor')->where('status', 'active')->get();
        // $data['assign'] = TradeLicence::where('assigned_sp','!=',null)->whereNotIn('delivery_status', ['Cancelled', 'Delivered','Returned'])->get();
        return view('admin.supervisor_details', $data);
    }

    public function delivery_man_details(Request $request)
    {
        $query = TradeLicence::with('deliveryman');
        if ($request->deliveryman) {
            $query->where('assigned_dm', $request->deliveryman)
                ->whereNotIn('delivery_status', ['Delivered', 'Returned']);
            $data['assign_to_dm'] = $query->get();
        } else {
            $data['assign_to_dm'] = TradeLicence::where('assigned_dm', '!=', null)
                ->whereIn('delivery_status', ['Assigned to SP', 'Assigned to DM', 'Processing', 'Out for Delivery', 'Hold', 'Cancelled'])->get();
        }

        $data['select_supervisors'] = User::where('role', 'supervisor')->where('status', 'active')->get();
        $data['select_deliverymans'] = User::where('role', 'deliveryman')->where('status', 'active')->get();
        return view('admin.delivery_man_details', $data);
    }

    public function getDeliverymenBySupervisorZone($supervisorId)
    {
        $supervisor = User::find($supervisorId);

        if (!$supervisor) {
            return response()->json([], 404);
        }

        $zone = $supervisor->zone;

        $deliverymen = User::where('zone', $zone)
            ->where('role', 'deliveryman') // assuming you have a 'role' column
            ->get();

        return response()->json($deliverymen);
    }

    public function call_verification(Request $request)
    {
        $query = TradeLicence::with('deliveryman');
        if ($request->deliveryman) {
            $query->where('assigned_dm', $request->deliveryman)
                  ->whereIn('delivery_status', ['Assigned to SP', 'Assigned to DM', 'Processing', 'Out for Delivery', 'Hold', 'Cancelled']);
            $data['call_verify'] = $query->get();
        }

        else {
            $data['call_verify'] = TradeLicence::whereIn('delivery_status', ['Assigned to SP', 'Assigned to DM', 'Processing', 'Out for Delivery', 'Hold', 'Cancelled'])->get();
        }

        $data['select_supervisors'] = User::where('role', 'supervisor')->where('status', 'active')->get();
        $data['select_deliverymans'] = User::where('role', 'deliveryman')->where('status', 'active')->get();
        return view('admin.call_verification', $data);
    }

    public function delivery_status(Request $request)
    {
        $query = TradeLicence::with('deliveryman');
        if ($request->deliveryman) {
            $query->where('assigned_dm', $request->deliveryman)
                  ->whereIn('delivery_status', ['Assigned to SP', 'Assigned to DM', 'Processing', 'Out for Delivery', 'Hold', 'Cancelled']);
            $data['delivery_status'] = $query->get();
        }

        else {
            $data['delivery_status'] = TradeLicence::whereIn('delivery_status', ['Assigned to SP', 'Assigned to DM', 'Processing', 'Out for Delivery', 'Hold', 'Cancelled'])->get();
        }

        $data['select_supervisors'] = User::where('role', 'supervisor')->where('status', 'active')->get();
        $data['select_deliverymans'] = User::where('role', 'deliveryman')->where('status', 'active')->get();
        return view('admin.delivery_status', $data);
    }

    public function verified_by_sp(Request $request)
    {
        $query = TradeLicence::query();
        if ($request->supervisor) {
            $query->where('assigned_sp', $request->supervisor)
                  ->whereNotNull('sp_1st_status');
            $data['verified'] = $query->get();
        }

        else {
            $data['verified'] = TradeLicence::whereNotNull('sp_1st_status')->get();
        }
        $data['select_supervisors'] = User::where('role', 'supervisor')->where('status','active')->get();
        return view('admin.verified_by_sp', $data);
    }

    public function delivered()
    {
        $data['delivered'] = TradeLicence::where('delivery_status','Delivered')->get();
        return view('admin.delivered',$data);
    }

    public function delivery_report(Request $request)
    {
        $query = TradeLicence::where('delivery_status', 'Delivered');

    // Filter by zone if selected
    if ($request->filled('zonename')) {
        $query->where('zonename', $request->zonename);
    }

    // Get records (either zone filtered or all with delivery_status = 'Delivered')
    $records = $query->get();

    // If both from_date and to_date are provided, filter by date range
    if ($request->filled('from_date') && $request->filled('to_date')) {
        try {
            $start = Carbon::createFromFormat('Y-m-d', $request->from_date)->startOfDay();
            $end = Carbon::createFromFormat('Y-m-d', $request->to_date)->endOfDay();

            // Manually filter the collection by return_date
            $records = $records->filter(function ($record) use ($start, $end) {
                try {
                    $recordDate = Carbon::createFromFormat('d-m-Y h:i A', $record->delivery_date);
                    return $recordDate->between($start, $end);
                } catch (\Exception $e) {
                    return false;
                }
            })->values(); // Reindex the filtered collection
        } catch (\Exception $e) {
            // Optional: handle invalid date input
        }
    }

        $data['records'] = $records;
        $data['supervisors'] = User::where('role','supervisor')->where('status','active')->get();
        $data['deliverymans'] = User::where('role','deliveryman')->where('status','active')->get();
        return view('admin.delivery_report',$data);
    }

    public function dncc_return(Request $request)
    {

    $query = TradeLicence::where('delivery_status', 'Returned');

    // Filter by zone if selected
    if ($request->filled('zonename')) {
        $query->where('zonename', $request->zonename);
    }

    // Get records (either zone filtered or all with delivery_status = 'Returned')
    $records = $query->get();

    // If both from_date and to_date are provided, filter by date range
    if ($request->filled('from_date') && $request->filled('to_date')) {
        try {
            $start = Carbon::createFromFormat('Y-m-d', $request->from_date)->startOfDay();
            $end = Carbon::createFromFormat('Y-m-d', $request->to_date)->endOfDay();

            // Manually filter the collection by return_date
            $records = $records->filter(function ($record) use ($start, $end) {
                try {
                    $recordDate = Carbon::createFromFormat('d-m-Y h:i A', $record->return_date);
                    return $recordDate->between($start, $end);
                } catch (\Exception $e) {
                    return false;
                }
            })->values(); // Reindex the filtered collection
        } catch (\Exception $e) {
            // Optional: handle invalid date input
        }
    }

        $data['records'] = $records;
        $data['supervisors'] = User::where('role','supervisor')->where('status','active')->get();
        $data['deliverymans'] = User::where('role','deliveryman')->where('status','active')->get();
        return view('admin.return',$data);
    }


    public function showTradeMap()
    {
    $data['locations'] = TradeLicence::select(
        'businame',
        'OwnerName',
        'zonename',
        'Mob',
        'busiadd',
        'latitude',
        'longitude')
        ->whereNotNull('latitude')
        ->get();

        return view('admin.map', $data);
    }

    public function otp_verification()
    {
        $data['otps'] = Otp::orderBy('id','desc')->get();
        return view('admin.otp_verification',$data);
    }



}
