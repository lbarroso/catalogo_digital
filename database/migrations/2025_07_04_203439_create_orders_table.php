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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();                             // PK interna
            $table->bigInteger('order_id')->index();  // ID original de Supabase
            $table->date('docfec')->index();         // Fecha de pedido
            $table->timestamp('sync_date')->nullable()->index();
            $table->integer('almcnt')->index();       // Almacén
            $table->timestamp('doccreated')->nullable();
            $table->timestamp('docupdated')->nullable();
            $table->integer('ctecve')->index();       // Cliente
            $table->string('ctename', 120);
            $table->string('artcve', 50)->nullable(); // Artículo
            $table->string('artdesc')->nullable();
            $table->string('presentacion',6)->default('1');
            $table->integer('doccant')->unsigned()->default(0);
            $table->decimal('artprventa', 10, 2)->unsigned()->default(0);
            $table->decimal('importe', 12, 2)->unsigned()->default(0);
            $table->timestamps();
    
            // Para evitar duplicados exactos de la misma orden-línea
            $table->unique(['order_id','artcve','almcnt'], 'uq_order_line');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
