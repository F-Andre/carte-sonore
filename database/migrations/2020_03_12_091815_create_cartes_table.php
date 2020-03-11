<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('cartes', function (Blueprint $table) {
      $table->id();
      $table->string('title', 100)->unique();
      $table->text('description')->nullable();
      $table->string('coordinates');
      $table->foreignId('image_id')->constrained();
      $table->foreignId('audio_id')->constrained();
      $table->unsignedBigInteger('creator_id');
      $table->foreign('creator_id')->references('id')->on('users');
      $table->unsignedBigInteger('editor_id')->nullable();
      $table->foreign('editor_id')->references('id')->on('users');
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
    Schema::table('cartes', function (Blueprint $table) {
      $table->dropForeign(['user_id', 'audio_id', 'image_id']);
    });

    Schema::dropIfExists('cartes');
  }
}
