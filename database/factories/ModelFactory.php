<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->firstName,
        'email' => $faker->unique()->safeEmail,
        'password' => $faker->word,
        'remember_token' => str_random(10),
        'surname' => $faker->lastName,
        'patronymic' => $faker->firstName,
        'job' => 'manager',
        'username' => $faker->word,
        'active' => rand(0, 1),
        'work_hours' => rand(0, 1)
    ];
});

$factory->define(App\Models\Client::class, function (Faker\Generator $faker) {
    static $password;

    return [

            'user_id'      => rand(1, 100),
            'name'         => $faker->company,
            'phone_work'   => $faker->phoneNumber,
            'phone_mobile' => $faker->tollFreePhoneNumber,
            'fio'          => $faker->name,
            'job'          => $faker->jobTitle,
            'birthday'     => $faker->date('d.m.Y'),
            'email'        => $faker->email,
            'events'       => $faker->text,
            'site'         => $faker->domainName,
            'address'      => $faker->address,
            'description'  => $faker->text,
            'hobby'        => $faker->text
    ];
});