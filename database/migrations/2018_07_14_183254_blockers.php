<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Blockers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blockers', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('blockable_id');
            $table->string('blockable_type');

            $table->integer('blocker_id')->nullable();
            $table->string('blocker_type')->nullable();

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
        Schema::dropIfExists('blockers');
    }
}
