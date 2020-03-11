<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Image;
use Faker\Generator as Faker;

$factory->define(Image::class, function (Faker $faker) {
    return [
      'name' => $faker->unique()->word(),
      'ext' => 'jpg',
      'size' => $faker->rand(800, 100000),
      'path' => '/images/brest.jpg',
      'card_id' => 1,
      'user_id' => 1
    ];
});
