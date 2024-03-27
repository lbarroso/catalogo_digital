<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->date('pvfecha')->nullable();
            $table->integer('ctecve')->default(1);
            $table->decimal('pvtotal', 10, 2)->default(0);
            $table->decimal('pvcash', 10, 2)->default(0);                                
            $table->string('pvtipopago', 25)->default('efectivo');
            $table->integer('user_id')->default(0);
            $table->uuid('uuid')->nullable();            
            $table->string('pvstatus', 2)->default('A');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
};
