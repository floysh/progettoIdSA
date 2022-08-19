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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->enum('category', array('weapon', 'spell', 'object', 'wearable'));

            $table->string('imagepath');
            $table->string('name');
            $table->float('price');
            $table->integer('quantity');
            $table->text('description');

            $table->boolean('is_disabled'); //segna i prodotti "eliminati"
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
};
