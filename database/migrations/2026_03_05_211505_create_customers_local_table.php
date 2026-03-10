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
        Schema::create('customers_local', function (Blueprint $table) {
            $table->id();
              // Identidad del almacén (NO viene en Excel; la obtendrás de Auth::user()->almcnt)
            $table->integer('almcnt')->index();

            // Columnas del Excel (mapeadas a snake_case)
            $table->unsignedSmallInteger('ruta_sup')->nullable()->index();      // Ruta Sup.
            $table->string('nombre_sup', 80)->nullable();                      // Nombre de Sup.
            $table->unsignedSmallInteger('canal')->nullable()->index();        // Canal

            $table->unsignedInteger('ctecve')->index();                        // Cliente (clave)
            $table->string('encargado', 120)->nullable();                      // Encargado
            $table->string('localidad', 120)->nullable()->index();             // Localidad

            $table->date('fecha_nac')->nullable();                             // Fecha de Nac.
            $table->string('rfc', 13)->nullable();                             // R.F.C.
            $table->string('curp', 18)->nullable();                            // C.U.R.P
            $table->unsignedBigInteger('rpu')->nullable();                     // R.P.U

            $table->char('sexo', 1)->nullable();                               // Sexo
            $table->string('telefono', 20)->nullable();                        // Telefono
            $table->string('codigo_postal', 10)->nullable();                   // C.Postal

            $table->date('fecha_pos')->nullable();                             // Fecha de Pos.
            $table->char('rit', 1)->nullable();                                // R.I.T

            $table->decimal('capital_diconsa', 14, 2)->nullable();             // Capital Diconsa
            $table->decimal('capital_comunit', 14, 2)->nullable();             // Capital Comunit.

            $table->decimal('longitud', 11, 8)->nullable();                    // Longitud
            $table->decimal('latitud', 10, 8)->nullable();                     // Latitud

            $table->date('fecha_apertura')->nullable();                        // Fecha de Apertura

            $table->timestamps();

            // Evita duplicados por almacén (clave natural para upsert)
            $table->unique(['almcnt', 'ctecve'], 'uq_customers_local_almcnt_ctecve');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers_local');
    }
};
