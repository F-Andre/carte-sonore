<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Card;
use Faker\Generator as Faker;

$factory->define(Card::class, function (Faker $faker) {
  $lat = -1000*(rand(4470, 4510));
  $long = 1000*(rand(48379, 48391));
  $imageId = rand(1, 50);
  $audioId = rand(1, 50);

  return [
    'title' => $faker->unique()->words(3),
    'description' => $faker->text(200),
    'coordinates' => $lat . ', ' . $long,
    'image_id' => $imageId,
    'audio_id' => $audioId,
    'creator_id' => 1
  ];
});
