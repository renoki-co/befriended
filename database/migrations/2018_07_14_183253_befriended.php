<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Befriended extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('followers', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('followable_id');
            $table->string('followable_type');

            $table->integer('follower_id')->nullable();
            $table->string('follower_type')->nullable();

            $table->timestamps();
        });

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
        Schema::dropIfExists('followers');
        Schema::dropIfExists('blockers');
    }
}
