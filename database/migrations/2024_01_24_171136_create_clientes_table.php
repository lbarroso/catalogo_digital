<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('ctenom',255)->unique();
            $table->string('cterfc',13)->nullable();
            $table->string('ctecp',5)->nullable();
            $table->string('ctereg')->nullable();
            $table->string('ctedir')->nullable();
            $table->string('cteemail',65)->nullable();
            $table->string('ctetel',10)->nullable();
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
        Schema::dropIfExists('clientes');
    }
}
