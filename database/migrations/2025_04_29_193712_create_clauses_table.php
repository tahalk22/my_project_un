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
        Schema::create('clauses', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('type') ; // CV  2 = Commercial Vehicle   مركبة تجارية  تقدم فخدمات  PV 1 = Private Vehicle  ملاكي
            $table->string('name') ;
           $table->float('additional_fee_per_year')->default(0); // يضاف فقط إذا كان type = 2  مصاريف اضافية في حالة الشرط الاضافي   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clauses');
    }
};
