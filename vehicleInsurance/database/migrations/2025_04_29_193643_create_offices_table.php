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
        Schema::create('offices', function (Blueprint $table) {
            $table->id();
       
            $table->unsignedBigInteger('company_id')->nullable() ;
            $table->foreign('company_id')->references('id')->on('companies') ->onDelete('cascade') ->onUpdate('cascade'); 
            $table->string('office_name') ;
            $table->string('manager_name') ;
            $table->string('phone') ;
            $table->string('email') ;
       
            $table->unsignedBigInteger('city_id')->nullable() ;
            $table->foreign('city_id')->references('id')->on('cities') ->onDelete('cascade') ->onUpdate('cascade'); 
            $table->string('location') ;

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offices');
    }
};
