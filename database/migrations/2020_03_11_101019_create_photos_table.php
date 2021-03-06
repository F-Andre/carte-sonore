<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotosTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('photos', function (Blueprint $table) {
      $table->id();
      $table->string('name')->unique();
      $table->string('ext');
      $table->unsignedInteger('size');
      $table->string('path', 80)->unique();
      $table->unsignedBigInteger('card_id');
      $table->unsignedBigInteger('user_id');
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
    Schema::dropIfExists('photos');
  }
}
