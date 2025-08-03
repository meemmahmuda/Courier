<?php

namespace App\Http\Controllers;

use App\Models\DeliveryMan;
use App\Models\User;
use App\Models\Otp;
use App\Models\TradeLicence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;


class DeliveryManController extends Controller
{
    public function login()
    {
        return view('deliveryman.login');
    }

    // public function authenticate(Request $request)
    // {

    //     $request->validate([
    //         'email' => 'required',
    //         'password' => 'required'
    //     ]);

    //     if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
    //         $user = Auth::user();
    //         if ($user->role != 'deliveryman') {
    //             Auth::logout();
    //             return redirect()->route('deliveryman.login')->with(
    //                 'error',
    //                 'Unauthorized User. Access Denied.'
    //             );
    //         }

    //         if ($user->status != 'active') {
    //             Auth::logout();
    //             return redirect()->route('deliveryman.login')->with(
    //                 'error',
    //                 'Your account is inactive. Please contact support.'
    //             );
    //         }

    //         return redirect()->route('deliveryman.dashboard');

    //     } else {
    //         return redirect()->route('deliveryman.login')->with('error', 'Invalid credentials. Please try again.');
    //     }
    // }


     public function authenticate(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if ($user && Hash::check($request->password, $user->password)) {

        if ($user->role !== 'deliveryman') {
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
                    ->subject('Your Deliveryman Login OTP');
        });

        session(['otp_email' => $user->email]);

        return redirect()->route('deliveryman.otp.verify.form');
    }

    return back()->with('error', 'Invalid credentials.');
}

public function showOtpForm()
{
    if (!session('otp_email')) {
        return redirect()->route('deliveryman.login')->with('error', 'Session expired. Please login again.');
    }

    return view('deliveryman.otp_verify');
}

public function verifyOtp(Request $request)
{
    $request->validate(['otp' => 'required']);

    $email = session('otp_email');
    $user = User::where('email', $email)->first();

    if (!$user) {
        return redirect()->route('deliveryman.login')->with('error', 'User not found.');
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

    // ✅ Login the user with default web guard
    Auth::login($user);

    session()->forget('otp_email');

    // ✅ Redirect to dashboard
    return redirect()->route('deliveryman.dashboard');
}

    public function dashboard()
    {
        $data['assigned'] = TradeLicence::where('assigned_dm', Auth::user()->id)->where('delivery_status', 'Assigned to DM')->count();
        $data['processing'] = TradeLicence::where('assigned_dm', Auth::user()->id)->whereIn('delivery_status', ['Processing', 'Out for Delivery'])->count();
        $data['delivered'] = TradeLicence::where('assigned_dm', Auth::user()->id)->where('delivery_status', 'Delivered')->count();
        $data['hold'] = TradeLicence::where('assigned_dm', Auth::user()->id)->where('delivery_status', 'Hold')->count();
        $data['cancelled'] = TradeLicence::where('assigned_dm', Auth::user()->id)->where('delivery_status', 'Cancelled')->count();
        $data['returned'] = TradeLicence::where('assigned_dm', Auth::user()->id)->where('delivery_status', 'Returned')->count();
        $data['number_of_supervisor'] = User::where('role', 'supervisor')->where('status','active')->count();
        $data['number_of_delivery_man'] = User::where('role', 'deliveryman')->where('status','active')->count();
        return view('deliveryman.dashboard', $data);
    }

    public function profile()
    {
        $data['supervisor_name'] = User::where('role', 'supervisor')->get();
        $data['total_delivered']  = TradeLicence::where('assigned_dm',Auth::user()->id)->where('delivery_status','Delivered')->count();
        return view('deliveryman.profile', $data);
    }

    public function profile_update(Request $request)
    {
        $user = Auth::user();

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

        return redirect()->route('deliveryman.profile')->with('success', 'Profile updated successfully.');
    }

    public function assignedTL()
    {
        $data['trade_licences'] = TradeLicence::where('assigned_dm', Auth::user()->id)->where('delivery_status', 'Assigned to DM')->get();
        return view('deliveryman.assignedTL', $data);
    }

    public function call_verification()
    {
        $data['all_datas'] = TradeLicence::where('assigned_dm', Auth::user()->id)->whereIn('delivery_status', ['Assigned to DM', 'Processing', 'Out for Delivery', 'Hold'])->get();
        return view('deliveryman.call_verification', $data);
    }

    public function call_store(Request $request)
    {

        $request->validate([
            'ref_no' => 'required|string|exists:trade_licences,ref_no',
            'call_type' => 'required|in:dm_1st_call,dm_2nd_call,dm_3rd_call',
            'datetime' => 'required',
            'status' => 'required|string',
        ]);

        $data = TradeLicence::where('ref_no', $request->ref_no)
            ->where('assigned_dm', Auth::user()->id)->first();

        if (!$data) {
            return redirect()->back()->with('error', 'You are not authorized to update this record.');
        }

        // Prevent updating again if already filled
        if (!empty($data->{$request->call_type})) {
            $call = trim($request->call_type, "dm_");
            return redirect()->back()->with('error', str_replace('_', ' ', $call) . ' is already recorded and cannot be updated.');
        }

        // Enforce sequence: 2nd can't be added if 1st is empty, 3rd can't be added if 1st or 2nd is empty
        if ($request->call_type === 'dm_2nd_call' && empty($data->dm_1st_call)) {
            return redirect()->back()->with('error', 'You must record 1st call before the 2nd call.');
        }

        if ($request->call_type === 'dm_3rd_call' && (empty($data->dm_1st_call) || empty($data->dm_2nd_call))) {
            return redirect()->back()->with('error', 'You must record 1st and 2nd calls before the 3rd call.');
        }

        // Determine status column
        $statusColumn = str_replace('_call', '_status', $request->call_type);

        // Update dynamic columns
        $data->update([
            $request->call_type => $request->datetime,
            $statusColumn => $request->status,
        ]);

        return redirect()->back()->with('success', 'Data updated successfully.');
    }

    public function delivery_status()
    {
        $data['delivery_status'] = TradeLicence::where('assigned_dm', Auth::user()->id)->whereIn('delivery_status', ['Assigned to DM', 'Processing', 'Out for Delivery', 'Hold','Cancelled'])->get();
        return view('deliveryman.delivery_status', $data);
    }

    public function delivery_status_store(Request $request)
    {

        $request->validate([
            'ref_no' => 'required|string|exists:trade_licences,ref_no',
            'delivery_status' => 'required|string',
        ]);

        $data = TradeLicence::where('ref_no', $request->ref_no)
            ->where('assigned_dm', Auth::user()->id)->first();

        if (!$data) {
            return redirect()->back()->with('error', 'You are not authorized to update this record.');
        }

        // Disallow update if status is already final
        if (in_array($data->delivery_status, ['Delivered', 'Cancelled', 'Returned'])) {
            return redirect()->back()->with('error', 'Delivery status cannot be changed once it is Delivered, Cancelled, or Returned.');
        }

        if($request->delivery_status === "Cancelled")
        {
            $reason = "Cancelled by DT";
        }
        else
        {
            $reason = '-';
        }

        $data->delivery_status = $request->delivery_status;
        $data->cancellation_reason = $reason;

        $data->update();

        return redirect()->back()->with('success', 'Data updated successfully.');
    }

    public function delivered()
    {
        $data['delivered'] = TradeLicence::where('assigned_dm', Auth::user()->id)->where('delivery_status', 'Delivered')->get();
        $data['delivery_slip'] = TradeLicence::where('assigned_dm', Auth::user()->id)
                                             ->where('otp_verification', 'Failed')
                                             ->whereNotIn('delivery_status',['Delivered', 'Cancelled', 'Returned'])->get();
        return view('deliveryman.delivered', $data);
    }

    public function delivered_store(Request $request)
    {
        $request->validate([
            'ref_no' => 'required',
            'otp_verification' => 'nullable',
            'delivery_slip' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'latitude' => 'required',
            'longitude' => 'required',
            'receivers_photo' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'delivery_status' => 'required',
            'delivery_date' => 'required',
        ]);

        $otp = Otp::where('ref_no', $request->ref_no)->first();
        $status = $otp->verification_status;

        $data = TradeLicence::where('ref_no', $request->ref_no)
        ->where('assigned_dm', Auth::user()->id)->first();

        if (!$data) {
            return redirect()->back()->with('error', 'You are not authorized to update this record.');
        }

        // Disallow update if status is already final
        if (in_array($data->delivery_status, ['Delivered', 'Cancelled', 'Returned'])) {
            return redirect()->back()->with('error', 'Unable to update data once it is Delivered, Cancelled, or Returned.');
        }

        // if ($request->selection === 'otp_radio') {
        //     $data->otp_verification = $request->otp_verification;
        //     $data->delivery_slip = '-'; // Reset delivery slip if otp selected
        // }


        if ($request->selection === 'delivery_radio') {
            $file = $request->file('delivery_slip');
            $fileName = time().'_'.$file->getClientOriginalName();
            $filePath = $file->storeAs('delivery_slips', $fileName, 'public');
            $data->delivery_slip = $filePath;
        }

        $data->latitude = $request->latitude;
        $data->longitude = $request->longitude;

        if ($request->hasFile('receivers_photo')) {
            $photo = $request->file('receivers_photo');
            $photoName = time().'_'.$photo->getClientOriginalName();
            $photoPath = $photo->storeAs('receivers_photos', $photoName, 'public');
            $data->receivers_photo = $photoPath;
        }

        if($request->selection === 'otp_radio' && $status === 'Success' && $request->otp_verification === 'Success')
        {
            $data->otp_verification = $request->otp_verification;
            $data->delivery_slip = '-'; // Reset delivery slip if otp selected
        }

        if($request->selection === 'otp_radio' && $status === 'Failed' && $request->otp_verification === 'Success')
        {
            return redirect()->back()->with('error','OTP verification failed. Please choose Delivery Slip.');
        }

        if($status == null)
        {
            return redirect()->back()->with('error','Please verify OTP first.');
        }

        $data->delivery_status = $request->delivery_status;
        $data->delivery_date = $request->delivery_date;
        $data->update();

        return back()->with('success', 'Delivery updated successfully.');
    }

    public function send_otp()
    {
        return view('deliveryman.send_otp');
    }

    public function verify_otp()
    {
        return view('deliveryman.verify_otp');
    }

    public function return()
    {
        $data['returned'] = TradeLicence::where('assigned_dm', Auth::user()->id)->where('delivery_status', 'Returned')->get();
        return view('deliveryman.return',$data);
    }

    public function returned_store(Request $request)
    {
        $request->validate([
            'ref_no' => 'required',
            'return_slip' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'delivery_status' => 'required',
            'return_date' => 'required',

        ]);

        $data = TradeLicence::where('ref_no', $request->ref_no)
        ->where('assigned_dm', Auth::user()->id)->first();

        if (!$data) {
            return redirect()->back()->with('error', 'You are not authorized to update this record.');
        }

        // Disallow update if status is already final
        if (in_array($data->delivery_status, ['Delivered','Returned'])) {
            return redirect()->back()->with('error', 'Unable to update data once it is Delivered, or Returned.');
        }

        if ($request->hasFile('return_slip')) {
            $return = $request->file('return_slip');
            $returnSlip = time().'_'.$return->getClientOriginalName();
            $returnSlipPath = $return->storeAs('return_slips', $returnSlip, 'public');
            $data->return_slip = $returnSlipPath;
        }

        $data->delivery_status = $request->delivery_status;
        $data->return_date = $request->return_date;
        $data->update();

        return back()->with('success', 'Return data updated successfully.');

    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('deliveryman.login')->with('success', 'Logout Successfully.');
    }
}
