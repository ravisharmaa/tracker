<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Department;
use App\Device;
use App\DeviceSubscription;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'department_id' => function () {
            return factory(Department::class)->create()->id;
        },
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->define(Device::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'name' => $faker->randomElement(['laptop', 'data-card', 'other-things']),
        'code' => $faker->uuid,
        'tag' => $faker->slug,
        'vendor' => $faker->text(),
        'description' => $faker->sentence,
    ];
});

$factory->define(DeviceSubscription::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
       'device_id' => function () {
           return factory(Device::class)->create()->id;
       },
        'subscription_id' => $faker->uuid,
        'requested_at' => now(),
    ];
});

$factory->define(Department::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'head'=> $faker->email,
    ];
});

$factory->define(\App\Subscription::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'item_id' => $faker->randomDigit,
        'item_name'=> $faker->name
    ];
});


