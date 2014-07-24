<?php

require_once __DIR__.'/src/init.php';

// use the factory to create a Faker\Generator instance
$faker = Faker\Factory::create();

for($c = 0; $c < 100; $c++){

    $addressRow = ORM::for_table('addresses')->create();
    $addressRow->youtube_id = $faker->md5;
    $addressRow->requests = $faker->numberBetween(5, $max = 500);;
    $addressRow->address = 'R' . $faker->sha1;
    $addressRow->name = $faker->name;
    $addressRow->description = $faker->realText($maxNbChars = 200, $indexSize = 2);
    $addressRow->updated = $faker->date('Y-m-d H:i:s', 'now');

    $addressRow->save();

    echo "created user number " . $c . '<br>';
}
