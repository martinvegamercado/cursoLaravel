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
        Schema::create('productos', function (Blueprint $table) {

            $table->mediumIncrements('idProducto');
            $table->string('prdNombre',75);
            $table->float('prdPrecio',8,2);
            $table->tinyInteger('idMarca');
            $table->tinyInteger('idCategoria');
            $table->text('prdDescripcion');
            $table->string('prdImagen',45);
            $table->boolean('prdActivo')->default(1);
          //foren key
            $table->foreign('idMarca')->references('idMarca')->on('marcas');
            $table->foreign('idCategoria')->references('idCategoria')->on('categorias');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
};
