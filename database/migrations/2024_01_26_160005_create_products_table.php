<?php
use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');            
            $table->integer('almcnt')->default(1);
            $table->string('artcve')->nullable(); 
            $table->string('artdesc')->nullable();                     
            $table->integer('prvcve')->default(1);
            $table->string('artstatus',2)->default('A');
            
            // campo familia_id relacion familias
            $table->foreignIdFor(Category::class)->constrained();
                        
            $table->string('codbarras',25)->nullable();
            $table->string('artmarca')->nullable();
            $table->string('artestilo')->nullable();
            $table->string('artcolor')->nullable();
            $table->string('artseccion')->nullable();
            $table->string('arttalla')->nullable();
            $table->integer('stock')->unsigned()->default(0);
            $table->string('artimg')->default('imagen.jpg');            
            $table->float('artprcosto')->unsigned()->default(0);
            $table->float('artprventa')->unsigned()->default(0);
            $table->string('artpesogrm',6)->default('1');
            $table->string('artpesoum',25)->default('PZA');
            $table->smallInteger('artganancia')->default(0);
            $table->smallInteger('eximin')->default(0);
            $table->smallInteger('eximax')->default(0);
            $table->longText('artdetalle')->nullable();
        
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
        Schema::dropIfExists('products');
    }
}
