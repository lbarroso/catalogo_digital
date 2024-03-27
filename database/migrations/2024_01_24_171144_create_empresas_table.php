<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->integer('almcnt')->default(1);
            $table->string('regnom');
            $table->string('regrfc')->nullable();
            $table->string('regcalle')->nullable();            
            $table->string('regnum')->nullable();
            $table->string('regcp')->nullable();
            $table->string('regtel')->nullable();            
            $table->string('regemail',65)->nullable();            
            $table->string('regmun')->nullable();
            $table->string('regloc')->nullable();
            $table->string('regedo')->nullable();
            $table->string('regleyenda')->nullable();
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
        Schema::dropIfExists('empresas');
    }
}
