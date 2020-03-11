<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePathwaysTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('pathways', function (Blueprint $table) {
      $table->id();
      $table->string('title')->unique();
      $table->text('description');
      $table->text('points');
      $table->text('misc');
      $table->unsignedBigInteger('creator_id');
      $table->unsignedBigInteger('editor_id')->nullable();
      $table->unsignedBigInteger('group_id')->nullable();
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
    Schema::dropIfExists('pathways');
  }
}
