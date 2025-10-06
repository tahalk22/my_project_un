<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up(): void
    {
        Schema::create('claims', function (Blueprint $table) {
            $table->id();

          
            $table->unsignedBigInteger('insurance_id')->nullable() ;
            $table->foreign('insurance_id')->references('id')->on('insurances') ->onDelete('cascade') ->onUpdate('cascade'); 
            $table->dateTime('claim_date') ;
            $table->json('attachments')->nullable(); 
            $table->text('description')->nullable(); 
            $table->unsignedSmallInteger('claim_status')->default(1) ; 
            // 1  = مطالبة جديدة
            //    2 =  قيد المعالجة
            //  3 = تم القبول
            //    4 =  تم الرفض
            $table->unsignedSmallInteger('claim_type')->default(1) ;  //   1: 'حادث  تصادم',     2: ' ضرر غير ناتج عن حادث ', 
                $table->string('deny_reason')->nullable(); 
                
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('claims');
    }
};
