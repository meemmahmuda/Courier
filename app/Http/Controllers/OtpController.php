<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Otp;
    use App\Models\TradeLicence;
    use Carbon\Carbon;
    use Illuminate\Support\Facades\Http; // For SMS API

    class OtpController extends Controller
    {
        // Send OTP
        public function sendOtp(Request $request)
        {
            $request->validate([
                'ref_no' => 'required|string',
                'mobile' => 'required|string',
            ]);

            $ref_no = TradeLicence::where('ref_no', $request->ref_no)->first();

            if(!$ref_no)
            {
                return redirect()->back()->with('error','Ref No not found!');
            }

            if($ref_no->delivery_status === 'Delivered')
            {
                return redirect()->back()->with('error','The file has already been delivered!');
            }

            if($ref_no->delivery_status === 'Returned')
            {
                return redirect()->back()->with('error','The file has already been returned!');
            }

            if($ref_no->delivery_status === 'Cancelled')
            {
                return redirect()->back()->with('error','The file has already been cancelled!');
            }

            $otp = rand(100000, 999999);

                Otp::updateOrCreate(
                ['ref_no' => $request->ref_no, 'mobile' => $request->mobile],
                [
                    'otp_code' => $otp,
                    'expires_at' => Carbon::now()->addMinutes(5),
                ]
            );

            $data = Otp::where('ref_no',$request->ref_no)->first();

            if($data->verification_status === 'Success')
            {
                return redirect()->back()->with('error','OTP verified earlier!');
            }

            if($data->verification_status === 'Failed')
            {
                return redirect()->back()->with('error','OTP verified earlier!');
            }



            // Example SMS API call (replace with your real SMS API)
            // Http::post('https://your-sms-api.com/send', [
            //     'to' => $request->mobile,
            //     'message' => "Your OTP for delivery ref #{$request->ref_no} is: $otp",
            //     // Include other required params like api_key if needed
            // ]);

            \Log::info("OTP for mobile {$request->mobile}, ref_no {$request->ref_no} is: $otp");

            return redirect()->route('deliveryman.verify_otp')->with('success','OTP sent successfully.');
        }


        // Verify OTP
        public function verifyOtp(Request $request)
    {
        $request->validate([
            'ref_no' => 'required|string',
            'mobile' => 'required|string',
            'otp_code' => 'required|string',
        ]);

        $otpRecord = Otp::where('ref_no', $request->ref_no)
                        ->where('mobile', $request->mobile)
                        ->first();

        if (!$otpRecord) {
            return redirect()->back()->with('error','No OTP sent for this mobile and reference number.');
        }

        // ✅ Check if already verified
        if ($otpRecord->verification_status === 'Success') {
            return redirect()->back()->with('error','OTP verified earlier.');
        }

        // ✅ Check if already verified
        if ($otpRecord->verification_status === 'Failed') {
            return redirect()->back()->with('error','You applied for delivery slip after OTP verification failed.');
        }

        // ✅ Check expiration
        if (Carbon::now()->gt(Carbon::parse($otpRecord->expires_at))) {
            return redirect()->back()->with('error','OTP expired.');
        }

        // ✅ Check if OTP is correct
        if ($otpRecord->otp_code !== $request->otp_code) {
            return redirect()->back()->with('error','Invalid OTP.');
        }

        // ✅ Mark as verified
        $otpRecord->verification_status = 'Success';
        $otpRecord->save();

        return redirect()->route('deliveryman.delivered')->with('success','OTP verified successfully.');
    }
}