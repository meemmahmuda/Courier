<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeLicence extends Model
{
    use HasFactory;
    protected $table = 'trade_licences';

    protected $fillable = [
        'ref_no',
        'cdate',
        'Gateway',
        'zonename',
        'businame',
        'OwnerName',
        'Mob',
        'busiadd',
        'TLNumber',
        'tl_page',
        'print_code',
        'uv_code',
        'PaymentType',
        'busitype',
        'bookvalue',
        'collection_amount',
        'actual_amount',
        'assigned_sp',
        'assigned_sp_date',
        'assigned_dm',
        'assigned_dm_date',
        'sp_1st_call',
        'sp_1st_status',
        'sp_2nd_call',
        'sp_2nd_status',
        'sp_3rd_call',
        'sp_3rd_status',
        'dm_1st_call',
        'dm_1st_status',
        'dm_2nd_call',
        'dm_2nd_status',
        'dm_3rd_call',
        'dm_3rd_status',
        'latitude',
        'longitude',
        'delivery_status',
        'delivery_date',
        'otp_verification',
        'delivery_slip',
        'receivers_photo',
        'cancellation_reason',
        'return_date',
        'return_slip',
        'product_type',
    ];

    public function supervisor()
    {
        return $this->belongsTo(User::class,'assigned_sp');
    }

    public function deliveryman()
    {
        return $this->belongsTo(User::class,'assigned_dm');
    }

}
