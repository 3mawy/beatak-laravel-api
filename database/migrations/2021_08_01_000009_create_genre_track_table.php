<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenreTrackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genre_track', function (Blueprint $table) {
            $table->id();
            $table->foreignId('track_id')
                ->unsigned()
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('genre_id')
                ->unsigned()
                ->constrained()
                ->onDelete('cascade');
            $table->decimal('price', 10, 2);

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
        Schema::dropIfExists('genre_track');
    }
}
