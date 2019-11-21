<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresenceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presence_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('presence_id')->unsigned();
            // $table->bigInteger('presence_type_id')->unsigned();
            $table->string('time_entry');
            $table->string('time_out');
            $table->timestamps();

            $table->foreign('presence_id')->references('id')->on('presences')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreign('presence_type_id')->references('id')->on('presence_types')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('presence_details');
    }
}
