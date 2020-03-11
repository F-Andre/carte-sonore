<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAudioTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('audio', function (Blueprint $table) {
      $table->id();
      $table->string('name')->unique();
      $table->string('ext');
      $table->unsignedInteger('size');
      $table->unsignedInteger('duration');
      $table->string('path');
      $table->foreignId('user_id')->constrained();
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
    Schema::table('audio', function (Blueprint $table) {
      $table->dropForeign(['user_id']);
    });

    Schema::dropIfExists('audio');
  }
}
