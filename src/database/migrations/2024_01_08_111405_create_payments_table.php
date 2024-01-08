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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->default(0);
            $table->string('payment_id')->nullable();
            $table->string('track_id')->unique();
            $table->decimal('amount')->nullable();
            $table->string('tran_id')->nullable();
            $table->string('ref_id')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->string('result')->nullable();
            $table->longText('info')->nullable(); 
            $table->string('udf1')->nullable(); 
            $table->string('udf2')->nullable(); 
            $table->string('udf3')->nullable(); 
            $table->string('udf4')->nullable(); 
            $table->string('udf5')->nullable();  
            $table->timestamps();
            
        });   
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
