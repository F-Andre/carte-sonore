<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('cards', function (Blueprint $table) {
      $table->id();
      $table->string('title', 100)->unique();
      $table->text('description')->nullable();
      $table->string('coordinates');
      $table->unsignedBigInteger('image_id')->nullable();
      $table->unsignedBigInteger('audio_id')->nullable();
      $table->unsignedBigInteger('pathway_id')->nullable();
      $table->unsignedBigInteger('group_id')->nullable();
      $table->unsignedBigInteger('creator_id');
      $table->unsignedBigInteger('editor_id')->nullable();
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
    Schema::dropIfExists('cards');
  }
}
