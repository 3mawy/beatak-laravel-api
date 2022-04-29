<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLicenseTrackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('license_track', function (Blueprint $table) {
            $table->string('uid')->default('aaa');
            $table->primary(['uid', 'track_id', 'license_id']);
            $table->foreignId('track_id')
                ->unsigned()
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('license_id')
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
        Schema::dropIfExists('license_track');
    }
}
