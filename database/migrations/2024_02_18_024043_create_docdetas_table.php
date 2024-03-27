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
        Schema::create('docdetas', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->integer('product_id')->default(0);
            $table->smallInteger('movcve')->default(51);
            $table->integer('docord')->default(0);
            $table->string('artcve')->nullable();
            $table->string('codbarras',25)->nullable();
            $table->string('artdesc')->nullable();
            $table->float('artprcosto')->unsigned()->default(0);
            $table->float('artdescto')->default(0);
            $table->float('artprventa')->unsigned()->default(0);
            $table->float('docimporte')->unsigned()->default(0);
            $table->string('artpesogrm',6)->default('1');
            $table->string('artpesoum',3)->default('PZA');
            $table->smallInteger('artganancia')->default(0);
            $table->float('doccant')->default(1);
            $table->string('docstatus',2)->default('A');
            $table->string('docsession')->nullable();
            $table->integer('numberid')->default(0);
            $table->integer('user_id')->default(0);
            $table->string('uuid')->nullable();

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
        Schema::dropIfExists('docdetas');
    }
};
