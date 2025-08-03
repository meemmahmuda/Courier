<?php

namespace App\Http\Controllers;

use App\Models\Supervisor;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Otp;
use App\Models\TradeLicence;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class SupervisorController extends Controller
{
    public function login()
    {
        return view('supervisor.login');
    }

    public function logout()
    {
        Auth::guard('supervisor')->logout();
        return redirect()->route('supervisor.login')->with('success', 'Logged out successfully');
    }

    // public function authenticate(Request $request)
    // {
    //     $request->validate([
    //         'email'=>'required',
    //         'password'=>'required'
    //     ]);

    //     if(Auth::guard('supervisor')->attempt([
    //         'email'=>$request->email,
    //         'password'=>$request->password]))
    //         {
    //             if(Auth::guard('supervisor')->user()->role != 'supervisor'){
    //                 Auth::guard('supervisor')->logout();
    //                 return redirect()->route('supervisor.login')->with('error', 'Access denied ! Unauthorised user.');
    //             }

    //             if(Auth::guard('supervisor')->user()->status != 'active'){
    //                 Auth::guard('supervisor')->logout();
    //                 return redirect()->route('supervisor.login')->with('error', 'Your account is inactive. Please contact support.');
    //             }

    //             return redirect()->route('supervisor.dashboard');
    //         }

    //         else
    //         {
    //             return redirect()->route('supervisor.login')->with('error', 'Invalid credentials. Please try again.');
    //         }
    // }


    public function authenticate(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if ($user && Hash::check($request->password, $user->password)) {

        if ($user->role !== 'supervisor') {
            return back()->with('error', 'Access denied! Unauthorized user.');
        }

        if ($user->status !== 'active') {
            return back()->with('error', 'Your account is inactive.');
        }

        // Generate OTP
        // $otp = rand(100000, 999999);
        $otp = 123456;
        $user->otp_code = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(5);
        $user->save();

        // Send OTP email
        Mail::raw("Your OTP code is: $otp", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Your Supervisor Login OTP');
        });

        session(['otp_email' => $user->email]);

        return redirect()->route('supervisor.otp.verify.form');
    }

    return back()->with('error', 'Invalid credentials.');
}

public function showOtpForm()
{
    if (!session('otp_email')) {
        return redirect()->route('supervisor.login')->with('error', 'Session expired. Please login again.');
    }

    return view('supervisor.otp_verify');
}

public function verifyOtp(Request $request)
{
    $request->validate(['otp' => 'required']);

    $email = session('otp_email');
    $user = User::where('email', $email)->first();

    if (!$user) {
        return redirect()->route('supervisor.login')->with('error', 'User not found.');
    }

    if (
        $user->otp_code !== $request->otp ||
        Carbon::now()->gt($user->otp_expires_at)
    ) {
        return back()->with('error', 'Invalid or expired OTP.');
    }

    // Clear OTP
    $user->otp_code = null;
    $user->otp_expires_at = null;
    $user->save();

    // ✅ Login using supervisor guard
    Auth::guard('supervisor')->login($user);

    session()->forget('otp_email');

    // ✅ Redirect to dashboard
    return redirect()->route('supervisor.dashboard');
}

    public function dashboard()
    {
        $data['assigned'] = TradeLicence::where('assigned_sp', Auth::guard('supervisor')->user()->id)->where('delivery_status', 'Assigned to SP')->count();
        $data['processing'] = TradeLicence::where('assigned_sp', Auth::guard('supervisor')->user()->id)->whereIn('delivery_status', ['Processing', 'Out for Delivery'])->count();
        $data['delivered'] = TradeLicence::where('assigned_sp', Auth::guard('supervisor')->user()->id)->where('delivery_status', 'Delivered')->count();
        $data['hold'] = TradeLicence::where('assigned_sp', Auth::guard('supervisor')->user()->id)->where('delivery_status', 'Hold')->count();
        $data['cancelled'] = TradeLicence::where('assigned_sp', Auth::guard('supervisor')->user()->id)->where('delivery_status', 'Cancelled')->count();
        $data['returned'] = TradeLicence::where('assigned_sp', Auth::guard('supervisor')->user()->id)->where('delivery_status', 'Returned')->count();
        $data['number_of_supervisor'] = User::where('role', 'supervisor')->where('status','active')->count();
        $data['number_of_delivery_man'] = User::where('role', 'deliveryman')->where('status','active')->count();
        return view('supervisor.dashboard', $data);
    }

    public function profile()
    {
        return view('supervisor.profile');
    }

    public function profile_update(Request $request)
    {
        $user = Auth::guard('supervisor')->user();

        $request->validate([
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
            'mobile.unique' => 'Mobile number is already exist!',
            'mobile.digits' => 'Mobile number must be exactly 11 digits.',
        ]);

        $data = [];

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

        return redirect()->route('supervisor.profile')->with('success', 'Profile updated successfully.');
    }

    public function assignedTL()
    {
        $data['trade_licences'] = TradeLicence::where('assigned_sp', Auth::guard('supervisor')->user()->id)->where('delivery_status', 'Assigned to SP')->get();
        $data['count_total_assigned_to_sp'] = TradeLicence::where('assigned_sp', Auth::guard('supervisor')->user()->id)->where('delivery_status', 'Assigned to SP')->count();
        return view('supervisor.assignedTL', $data);
    }


    public function tl_assign_to_dm(Request $request)
    {

        $query = TradeLicence::query();

        if ($request->filled('zonename')) {
        $query->where('zonename', $request->zonename)
              ->where('assigned_sp',Auth::guard('supervisor')->user()->id)
              ->whereNull('assigned_dm');

        $data['assign_to_sp'] = $query->get();
        }

        else{
            $data['assign_to_sp'] = TradeLicence::where('assigned_sp',Auth::guard('supervisor')->user()->id)
                                                ->whereNull('assigned_dm')->get();
        }

        $data['deliverymans'] = User::where('role','deliveryman')->where('status','active')
                                    ->where('zone',Auth::guard('supervisor')->user()->zone)->get();

        $user = Auth::guard('supervisor')->user();
        $data['zones'] = array_map('trim', explode(',', $user->zone));

        return view('supervisor.tl_assign_to_dm',$data);
    }


    public function tl_assign_to_dm_store(Request $request)
{
    $request->validate([
        'assigned_dm' => 'required',
        'ref_no' => 'required|array',
        'assigned_dm_date' => 'required',
    ]);

    $refNos = $request->ref_no;
    $supervisorId = Auth::guard('supervisor')->user()->id;

    // Fetch records matching ref_no and assigned_sp
    $records = TradeLicence::whereIn('ref_no', $refNos)
                ->where('assigned_sp', $supervisorId)
                ->get();

    if ($records->isEmpty()) {
        return redirect()->back()->with('error', 'You are not authorized to update these records.');
    }

    // Check if any ref_no has already been assigned
    $alreadyAssigned = $records->filter(function ($item) {
        return !is_null($item->assigned_dm);
    });

    if ($alreadyAssigned->isNotEmpty()) {
        return redirect()->back()->with('error', 'Some TLs have already been assigned!');
    }

    // Update all matching records
    foreach ($records as $record) {
        $record->update([
            'assigned_dm' => $request->assigned_dm,
            'assigned_dm_date' => $request->assigned_dm_date,
            'delivery_status' => 'Assigned to DM',
        ]);
    }

    return redirect()->back()->with('success', 'TL assigned to Delivery Man Successfully.');
}



    public function call_verification(Request $request)
    {
        $query = TradeLicence::with('deliveryman');
        if ($request->assigned_dm) {
            $query->where('assigned_dm', $request->assigned_dm)->where('assigned_sp',Auth::guard('supervisor')->user()->id)
                ->whereIn('delivery_status', ['Assigned to DM', 'Processing', 'Out for Delivery', 'Hold']);

            $data['all_datas'] = $query->get();
        }

        else{

            $data['all_datas'] = TradeLicence::where('assigned_sp',Auth::guard('supervisor')->user()->id)
                            ->whereNotNull('assigned_dm')
                            ->whereIn('delivery_status',['Assigned to DM', 'Processing', 'Out for Delivery', 'Hold'])->get();

        }

        $data['deliverymans'] = User::where('role','deliveryman')->where('status','active')
                            ->where('zone',Auth::guard('supervisor')->user()->zone)->get();

        return view('supervisor.call_verification',$data);
    }

    public function delivery_status(Request $request)
    {
        $query = TradeLicence::with('deliveryman');
        if ($request->assigned_dm) {
            $query->where('assigned_dm', $request->assigned_dm)->where('assigned_sp',Auth::guard('supervisor')->user()->id)
                ->whereIn('delivery_status', ['Assigned to DM', 'Processing', 'Out for Delivery', 'Hold','Cancelled']);

            $data['all_datas'] = $query->get();
        }

        else{

            $data['all_datas'] = TradeLicence::where('assigned_sp',Auth::guard('supervisor')->user()->id)
                            ->whereNotNull('assigned_dm')
                            ->whereIn('delivery_status',['Assigned to DM', 'Processing', 'Out for Delivery', 'Hold','Cancelled'])->get();

        }

        $data['deliverymans'] = User::where('role','deliveryman')->where('status','active')
                            ->where('zone',Auth::guard('supervisor')->user()->zone)->get();

        return view('supervisor.delivery_status',$data);
    }


    public function verified_by_sp()
    {
        $data['all_datas'] = TradeLicence::where('assigned_sp', Auth::guard('supervisor')->user()->id)
                                        ->where('delivery_status','Hold')->get();
        return view('supervisor.verified_by_sp',$data);
    }


    public function verified_by_sp_store(Request $request)
    {
        $request->validate([
            'ref_no' => 'required|string|exists:trade_licences,ref_no',
            'call_type' => 'required|in:sp_1st_call,sp_2nd_call,sp_3rd_call',
            'datetime' => 'required',
            'status' => 'required|string',
        ]);

        $data = TradeLicence::where('ref_no', $request->ref_no)
            ->where('assigned_sp', Auth::guard('supervisor')->user()->id)->first();

        if (!$data) {
        return redirect()->back()->with('error', 'You are not authorized to update this record.');
        }

        // Prevent updating again if already filled
        if (!empty($data->{$request->call_type})) {
            $call = trim($request->call_type, "sp_");
            return redirect()->back()->with('error', str_replace('_', ' ', $call) . ' is already recorded and cannot be updated.');
        }

        // Enforce sequence: 2nd can't be added if 1st is empty, 3rd can't be added if 1st or 2nd is empty
        if ($request->call_type === 'sp_2nd_call' && empty($data->sp_1st_call)) {
            return redirect()->back()->with('error', 'You must record 1st call before the 2nd call.');
        }

        if ($request->call_type === 'sp_3rd_call' && (empty($data->sp_1st_call) || empty($data->sp_2nd_call))) {
            return redirect()->back()->with('error', 'You must record 1st and 2nd calls before the 3rd call.');
        }

        // Determine status column
        $statusColumn = str_replace('_call', '_status', $request->call_type);

        // Update dynamic columns
        $data->update([
            $request->call_type => $request->datetime,
            $statusColumn => $request->status,
        ]);

        return redirect()->back()->with('success','Data updated successfully.');
    }

    public function delivered()
    {
        $data['delivered'] = TradeLicence::where('assigned_sp', Auth::guard('supervisor')->user()->id)->where('delivery_status', 'Delivered')->get();
        $data['dm'] = User::where('role','deliveryman')->where('status','active')->get();
        return view('supervisor.delivered', $data);
    }


    public function delivery_report(Request $request)
    {
        // $query = TradeLicence::query();
        // if($request->zonename){
        //     $query->where('zonename',$request->zonename)
        //     ->where('assigned_sp',Auth::guard('supervisor')->user()->id)
        //     ->where('delivery_status','Delivered');

        //     $data['delivery_reports'] = $query->get();
        // }

        // else{
        //     $data['delivery_reports'] = TradeLicence::where('assigned_sp',Auth::guard('supervisor')->user()->id)
        //     ->where('delivery_status','Delivered')->get();
        // }

        $query = TradeLicence::where('assigned_sp',Auth::guard('supervisor')->user()->id)
                             ->where('delivery_status', 'Delivered');

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

        $data['deliveryman'] = User::where('role','deliveryman')->where('status','active')->get();

        $user = Auth::guard('supervisor')->user();
        $data['zones'] = array_map('trim', explode(',', $user->zone));
        return view('supervisor.delivery_report',$data);
    }


    public function delivery_slip()
    {
        return view('supervisor.approve_delivery_slip');
    }

    public function delivery_slip_store(Request $request)
    {
        $request->validate([
            'ref_no' => 'required|string|exists:trade_licences,ref_no'
        ]);

        $data = TradeLicence::where('ref_no', $request->ref_no)
            ->where('assigned_sp', Auth::guard('supervisor')->user()->id)->first();

        if (!$data) {
        return redirect()->back()->with('error', 'You are not authorized to update this record.');
        }

        if ($data->delivery_status == 'Delivered') {
            return redirect()->back()->with('error', 'This file has already been delivered.');
            }

        if ($data->delivery_status == 'Returned') {
            return redirect()->back()->with('error', 'This file has already been returned.');
            }

        if ($data->delivery_status == 'Cancelled') {
            return redirect()->back()->with('error', 'This file has already been cancelled.');
            }

            // $data->otp_verification = 'Failed';
            // $data->update();

            $otp = Otp::where('ref_no', $request->ref_no)->first();

            if(!$otp)
            {
                $otp_failed = new Otp();
                $otp_failed->ref_no = $request->ref_no;
                $otp_failed->mobile = $data->Mob;
                $otp_failed->otp_code = 'OTP not sent';
                $otp_failed->verification_status = 'Failed';
                $otp_failed->save();

                return redirect()->back()->with('success','The following ref no is approved for delivery slip.');
            }

            if($otp->verification_status === 'Success')
            {
                return redirect()->back()->with('error','OTP verified successfully!');
            }

            if($otp->verification_status === 'Failed')
            {
                return redirect()->back()->with('error','OTP verification failed eailier!');
            }

            if ($otp->verification_status === null) {
                $otp->verification_status = 'Failed';
                $otp->update();

                $data->otp_verification = 'Failed';
                $data->update();
    }

        return redirect()->back()->with('success','The following ref no is approved for delivery slip.');
    }

    public function return_to_dncc(Request $request)
    {

        $query = TradeLicence::where('assigned_sp',Auth::guard('supervisor')->user()->id)
                             ->where('delivery_status', 'Returned');

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


        $data['deliveryman'] = User::where('role','deliveryman')->where('status','active')->get();

        $user = Auth::guard('supervisor')->user();
        $data['zones'] = array_map('trim', explode(',', $user->zone));
        return view('supervisor.return',$data);
    }
}
