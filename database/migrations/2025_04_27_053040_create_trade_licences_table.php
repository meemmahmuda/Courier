<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trade_licences', function (Blueprint $table) {
            $table->id();
            $table->string('ref_no')->unique();
            $table->string('cdate')->nullable();
            $table->string('Gateway')->nullable();
            $table->string('zonename')->nullable();
            $table->string('businame')->nullable();
            $table->string('OwnerName')->nullable();
            $table->string('Mob')->nullable();
            $table->text('busiadd')->nullable();
            $table->string('TLNumber')->nullable();
            $table->string('tl_page')->nullable();
            $table->string('print_code')->nullable();
            $table->string('uv_code')->nullable();
            $table->string('PaymentType')->nullable();
            $table->text('busitype')->nullable();
            $table->string('bookvalue')->nullable();
            $table->string('collection_amount')->nullable();
            $table->string('actual_amount')->nullable();
            $table->string('assigned_sp')->nullable();
            $table->string('assigned_sp_date')->nullable();
            $table->string('assigned_dm')->nullable();
            $table->string('assigned_dm_date')->nullable();
            $table->text('sp_1st_call')->nullable();
            $table->string('sp_1st_status')->nullable();
            $table->text('sp_2nd_call')->nullable();
            $table->string('sp_2nd_status')->nullable();
            $table->text('sp_3rd_call')->nullable();
            $table->string('sp_3rd_status')->nullable();
            $table->text('dm_1st_call')->nullable();
            $table->string('dm_1st_status')->nullable();
            $table->text('dm_2nd_call')->nullable();
            $table->string('dm_2nd_status')->nullable();
            $table->text('dm_3rd_call')->nullable();
            $table->string('dm_3rd_status')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('delivery_status')->nullable();
            $table->string('delivery_date')->nullable();
            $table->string('otp_verification')->nullable();
            $table->string('delivery_slip')->nullable();
            $table->string('receivers_photo')->nullable();
            $table->string('cancellation_reason')->nullable();
            $table->string('return_date')->nullable();
            $table->string('return_slip')->nullable();
            $table->string('product_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trade_licences');
    }
};
