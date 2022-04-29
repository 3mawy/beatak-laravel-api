<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTracksTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracks', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->integer('duration')->nullable();
            $table->string('url', 150)->nullable();
            $table->string('description', 300)->nullable();
            $table->boolean('active')->nullable();
            $table->integer('discount')->nullable();
            $table->foreignId('user_id')
                ->nullable()
                ->unsigned()
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('genre_id')
                ->nullable()
                ->unsigned()
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('type_id')
                ->nullable()
                ->unsigned()
                ->constrained()
                ->onDelete('cascade');
//            $table->foreignId('vocal_presence_id')
//                ->unsigned()
//                ->constrained()
//                ->onDelete('cascade');
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
        Schema::dropIfExists('tracks');
    }
}



