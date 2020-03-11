<?php

use Illuminate\Database\Seeder;

class CardTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    factory(App\Card::class, 40)->create()->each(function ($card) {
      $card->image()->save(factory(App\Image::class)->make());
      $card->audio()->save(factory(App\Audio::class)->make());
    });
  }
}
