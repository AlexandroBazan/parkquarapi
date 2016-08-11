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

$factory->define(Entities\Customers\Models\Customer::class, function ($faker) {
    return [
		'person_id' => function () {
            return factory(Impark\Filter\test\Person::class)->create()->id;
        },
		'delete'     => $faker->boolean,
		'created_id' => function () {
            return factory(Impark\Filter\test\Timestamp::class)->create()->id;
        },
        'updated_id' => function () {
            return factory(Impark\Filter\test\Timestamp::class)->create()->id;
        },
        'deleted_id' => function () {
            return factory(Impark\Filter\test\Timestamp::class)->create()->id;
        },
    ];
});

$factory->define(Impark\Filter\test\User::class, function ($faker) {
    return [
        'username'  => $faker->userName,
        'password'  => app('hash')->make($faker->password),
        'active'    => $faker->boolean,
        'person_id' => function () {
            return factory(Impark\Filter\test\Person::class)->create()->id;
        },
        'delete'     => $faker->boolean,
        'created_id' => function () {
            return factory(Impark\Filter\test\Timestamp::class)->create()->id;
        },
        'updated_id' => function () {
            return factory(Impark\Filter\test\Timestamp::class)->create()->id;
        },
        'deleted_id' => function () {
            return factory(Impark\Filter\test\Timestamp::class)->create()->id;
        },
    ];
});

$factory->define(Impark\Filter\test\Person::class, function ($faker) {
	$sexo = ['hombre', 'mujer'];
    return [
		'dni'       => $faker->numberBetween(70,79).$faker->numberBetween(4000,5600).$faker->numberBetween(10,99),
		'firstname' => $faker->firstname,
		'lastname'  => $faker->lastname,
		'gender'    => $sexo[rand(0,1)],
		'image'     => 'none',
		'birthday'     => $faker->date($format = 'Y-m-d', $max = '1992-02-25'),
		'delete'    => 0,
		'created_id' => function () {
            return factory(Impark\Filter\test\Timestamp::class)->create()->id;
        },
        'updated_id' => function () {
            return factory(Impark\Filter\test\Timestamp::class)->create()->id;
        },
        'deleted_id' => function () {
            return factory(Impark\Filter\test\Timestamp::class)->create()->id;
        },
    ];
});

$factory->define(Impark\Filter\test\BranchOffice::class, function ($faker) {
    return [
		'name'    => $faker->streetAddress, 
		'delete'    => 0,
        'created_id' => function () {
            return factory(Impark\Filter\test\Timestamp::class)->create()->id;
        },
        'updated_id' => function () {
            return factory(Impark\Filter\test\Timestamp::class)->create()->id;
        },
        'deleted_id' => function () {
            return factory(Impark\Filter\test\Timestamp::class)->create()->id;
        },
    ];
});

$factory->define(Impark\Filter\test\Group::class, function ($faker) {
    return [
        'name'    => $faker->unique()->jobTitle, 
        'delete'    => 0,
        'created_id' => function () {
            return factory(Impark\Filter\test\Timestamp::class)->create()->id;
        },
        'updated_id' => function () {
            return factory(Impark\Filter\test\Timestamp::class)->create()->id;
        },
        'deleted_id' => function () {
            return factory(Impark\Filter\test\Timestamp::class)->create()->id;
        },
    ];
});

$factory->define(Impark\Filter\test\Profile::class, function ($faker) {
    return [
        'name'    => $faker->unique()->jobTitle, 
        'group_id' => function () {
            return app('db')->table('groups')->orderByRaw('RAND()')->first()->id;
        },
        'delete'    => 0,
        'created_id' => function () {
            return factory(Impark\Filter\test\Timestamp::class)->create()->id;
        },
        'updated_id' => function () {
            return factory(Impark\Filter\test\Timestamp::class)->create()->id;
        },
        'deleted_id' => function () {
            return factory(Impark\Filter\test\Timestamp::class)->create()->id;
        },
    ];
});

$factory->define(Impark\Filter\test\Permision::class, function ($faker) {
    return [
        'user_id' => function () {
            return app('db')->table('users')->orderByRaw('RAND()')->first()->id;
        },
        'profile_id' => function () {
            return app('db')->table('profiles')->orderByRaw('RAND()')->first()->id;
        },
        'branch_office_id' => function () {
            return app('db')->table('branch_offices')->orderByRaw('RAND()')->first()->id;
        },
        'delete'    => 0,
        'created_id' => function () {
            return factory(Impark\Filter\test\Timestamp::class)->create()->id;
        },
        'updated_id' => function () {
            return factory(Impark\Filter\test\Timestamp::class)->create()->id;
        },
        'deleted_id' => function () {
            return factory(Impark\Filter\test\Timestamp::class)->create()->id;
        },
    ];
});


$factory->define(Impark\Filter\test\Timestamp::class, function ($faker) {
    return [
        'time'    => $faker->dateTime($max = 'now'), 
        'user_id' => 1, 
        'type'    => 'create', 
        'app_id'  => rand(1,2), 
        'ip'      => $faker->ipv4,
    ];
});


$factory->define(Entities\Routes\Models\Route::class, function ($faker) {
    return [
        'description'   => $faker->word.'::'.$faker->word.'::'.$faker->word.'::'.$faker->postcode, 
        'app_id'        => rand(1,2), 
        'delete'        => 0,
        'created_id'    => function () {
            return factory(Impark\Filter\test\Timestamp::class)->create()->id;
        },
        'updated_id'    => function () {
            return factory(Impark\Filter\test\Timestamp::class)->create()->id;
        },
        'deleted_id'    => function () {
            return factory(Impark\Filter\test\Timestamp::class)->create()->id;
        },
    ];
});

$factory->define(Entities\Accesses\Models\Access::class, function ($faker) {
    return [
        'profile_id' => function () {
            return app('db')->table('profiles')->orderByRaw('RAND()')->first()->id;
        },
        'route_id' => function () {
            return app('db')->table('routes')->orderByRaw('RAND()')->first()->id;
        },
        'active'        => 1,
        'delete'        => 0,
        'created_id'    => function () {
            return factory(Impark\Filter\test\Timestamp::class)->create()->id;
        },
        'updated_id'    => function () {
            return factory(Impark\Filter\test\Timestamp::class)->create()->id;
        },
        'deleted_id'    => function () {
            return factory(Impark\Filter\test\Timestamp::class)->create()->id;
        },
    ];
});

$factory->define(Entities\Vehicles\Models\Model::class, function ($faker) {
    return [
        'brand_id' => function () {
            return app('db')->table('vehicle_brands')->orderByRaw('RAND()')->first()->id;
        },
        'name' => $faker->company,
        'delete'        => 0,
        'created_id'    => function () {
            return factory(Impark\Filter\test\Timestamp::class)->create()->id;
        },
        'updated_id'    => function () {
            return factory(Impark\Filter\test\Timestamp::class)->create()->id;
        },
        'deleted_id'    => function () {
            return factory(Impark\Filter\test\Timestamp::class)->create()->id;
        },
    ];
});

$factory->define(Entities\Vehicles\Models\Vehicle::class, function ($faker) {

    $placa[0] = "{$faker->randomLetter}{$faker->randomLetter}-{$faker->randomDigit}{$faker->randomDigit}{$faker->randomDigit}{$faker->randomDigit}";
    $placa[1] = "{$faker->randomLetter}{$faker->randomLetter}{$faker->randomLetter}-{$faker->randomDigit}{$faker->randomDigit}{$faker->randomDigit}";
    return [
        'registation_plate' => $placa[rand(0,1)],
        'model_id' => function () {
            return app('db')->table('vehicle_models')->orderByRaw('RAND()')->first()->id;
        },
        'customer_id' => function () {
            return app('db')->table('customers')->orderByRaw('RAND()')->first()->id;
        },

        'type_id' => function () {
            return app('db')->table('vehicle_types')->orderByRaw('RAND()')->first()->id;
        },

        'color_id' => function () {
            return app('db')->table('vehicle_colors')->orderByRaw('RAND()')->first()->id;
        },
        'delete'        => 0,
        'created_id'    => function () {
            return factory(Impark\Filter\test\Timestamp::class)->create()->id;
        },
        'updated_id'    => function () {
            return factory(Impark\Filter\test\Timestamp::class)->create()->id;
        },
        'deleted_id'    => function () {
            return factory(Impark\Filter\test\Timestamp::class)->create()->id;
        },
    ];
});



