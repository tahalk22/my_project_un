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
        Schema::create('insurances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable() ;
            $table->foreign('user_id')->references('id')->on('users') ->onDelete('cascade') ->onUpdate('cascade'); 
            $table->unsignedBigInteger('office_id')->nullable() ;
            $table->foreign('office_id')->references('id')->on('offices') ->onDelete('cascade') ->onUpdate('cascade'); 

            $table->dateTime('version_date') ;
            $table->dateTime('from_date') ; // يبدا ظهيرة  اليوم الذي يلي تاريخ الاصدار 
            $table->dateTime('to_date') ;
            $table->string('insurance_name') ;

            $table->unsignedTinyInteger('id_type') ;
            $table->string('id_number') ;
            $table->string('phone') ;

            $table->string('insurance_location') ;
            $table->string('chassis_number') ;
            $table->string('motor_power') ;
            $table->string('motor_number') ;
            $table->unsignedSmallInteger('non_driver_passengers') ; // عدد الركاب بخلاف السائق
            $table->string('plate_number') ;
            $table->unsignedBigInteger('country_id')->nullable() ;
            $table->foreign('country_id')->references('id')->on('countries') ->onDelete('cascade') ->onUpdate('cascade'); 
            $table->unsignedBigInteger('car_type_id')->nullable() ;
            $table->foreign('car_type_id')->references('id')->on('car_types') ->onDelete('cascade') ->onUpdate('cascade'); 
            $table->unsignedBigInteger('clause_id')->nullable() ;
            $table->foreign('clause_id')->references('id')->on('clauses') ->onDelete('cascade') ->onUpdate('cascade'); 
            $table->year('made_year') ;
            $table->unsignedBigInteger('color_id')->nullable() ;
            $table->foreign('color_id')->references('id')->on('colors') ->onDelete('cascade') ->onUpdate('cascade'); 
            $table->unsignedBigInteger('years_number')->default(1) ; // عدد السنوات الي يبي يامنها 
            $table->float('installment')  ; 
            $table->float('tax')  ; 
            $table->float('supervision')  ; 
            $table->float('stamp')  ; 
            $table->float('version')  ; 
            $table->float('total')  ; 
            $table->softDeletes() ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurances');
    }
};
