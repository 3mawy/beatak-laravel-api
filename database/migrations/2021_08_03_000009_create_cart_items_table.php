<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartItemsTable extends Migration
{
    // TODO: Review
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->decimal('item_price');

            $table->foreignId('cart_id')
                ->unsigned()
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('track_id')
                ->unsigned()
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('license_id')
                ->unsigned()
                ->constrained()
                ->onDelete('cascade');

            $table->timestamps();
        });
//            $table->integer('quantity');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
}
