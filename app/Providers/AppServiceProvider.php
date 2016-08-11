<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->baseObjects();

        $this->groups();
        $this->profiles();
        $this->permissions();
        $this->routes();
        $this->accesses();
        $this->customers();
        $this->users();
        $this->vehicles();
        $this->brands();
        $this->branchoffices();
        $this->parkinglogs();
    }

    public function baseObjects()
    {
    	$this->app->bind('EntityError', function ($app) {
    		return new \Impark\Error\HttpErrorReporter;
    	});

    	$this->app->bind('EntityTimestamps', function ($app) {
    		return new \Impark\Timestamps\Timestamps(new \Impark\Timestamps\TimestampsModel);
    	});
    }

    public function groups()
    {
    	$this->app->bind('\Entities\Groups\Groups', function($app) {
    		return new \Entities\Groups\Groups(
    			new \Entities\Groups\Models\Group,
    			new \Entities\Groups\GroupsFilter,
    			new \Entities\Groups\GroupsValidator($app->make('validator')),
    			new \Entities\Groups\GroupsMutator, 
    			$app->make('EntityTimestamps'),
    			$app->make('EntityError')
    		);
    	});
    }

    public function profiles()
    {
    	$this->app->bind('\Entities\Profiles\Profiles', function($app) {
    		return new \Entities\Profiles\Profiles(
    			new \Entities\Profiles\Models\Profile,
    			new \Entities\Profiles\ProfilesFilter,
    			new \Entities\Profiles\ProfilesValidator($app->make('validator')),
    			new \Entities\Profiles\ProfilesMutator, 
    			$app->make('EntityTimestamps'),
    			$app->make('EntityError')
    		);
    	});
    }

    public function permissions()
    {
        $this->app->bind('\Entities\Permissions\Permissions', function($app) {
            return new \Entities\Permissions\Permissions(
                new \Entities\Permissions\Models\Permission,
                new \Entities\Permissions\PermissionsFilter,
                new \Entities\Permissions\PermissionsValidator($app->make('validator')),
                new \Entities\Permissions\PermissionsMutator, 
                $app->make('EntityTimestamps'),
                $app->make('EntityError')
            );
        });
    }

    public function routes()
    {
        $this->app->bind('\Entities\Routes\Routes', function($app) {
            return new \Entities\Routes\Routes(
                new \Entities\Routes\Models\Route,
                new \Entities\Routes\RoutesFilter,
                new \Entities\Routes\RoutesValidator($app->make('validator')),
                new \Entities\Routes\RoutesMutator, 
                $app->make('EntityTimestamps'),
                $app->make('EntityError')
            );
        });
    }

    public function accesses()
    {
        $this->app->bind('\Entities\Accesses\Accesses', function($app) {
            return new \Entities\Accesses\Accesses(
                new \Entities\Accesses\Models\Access,
                new \Entities\Accesses\AccessesFilter,
                new \Entities\Accesses\AccessesValidator($app->make('validator')),
                new \Entities\Accesses\AccessesMutator, 
                $app->make('EntityTimestamps'),
                $app->make('EntityError')
            );
        });
    }

    public function customers()
    {
        $this->app->bind('\Entities\Customers\Customers', function($app) {
            return new \Entities\Customers\Customers(
                new \Entities\Customers\Models\Customer,
                new \Entities\Customers\CustomersFilter,
                new \Entities\Customers\CustomersValidator($app->make('validator')),
                new \Entities\Customers\CustomersMutator, 
                $app->make('EntityTimestamps'),
                $app->make('EntityError')
            );
        });
    }

    public function users()
    {
        $this->app->bind('\Entities\Users\Users', function($app) {
            return new \Entities\Users\Users(
                new \Entities\Users\Models\User,
                new \Entities\Users\UsersFilter,
                new \Entities\Users\UsersValidator($app->make('validator')),
                new \Entities\Users\UsersMutator, 
                $app->make('EntityTimestamps'),
                $app->make('EntityError')
            );
        });
    }

    public function vehicles()
    {
        $this->app->bind('\Entities\Vehicles\Vehicles', function($app) {
            return new \Entities\Vehicles\Vehicles(
                new \Entities\Vehicles\Models\Vehicle,
                new \Entities\Vehicles\VehiclesFilter,
                new \Entities\Vehicles\VehiclesValidator($app->make('validator')),
                new \Entities\Vehicles\VehiclesMutator, 
                $app->make('EntityTimestamps'),
                $app->make('EntityError')
            );
        });
    }

    public function brands()
    {
        $this->app->bind('\Entities\Vehicles\Brands', function($app) {
            return new \Entities\Vehicles\Brands(
                new \Entities\Vehicles\Models\Brand,
                new \Entities\Vehicles\BrandsFilter,
                new \Entities\Vehicles\BrandsValidator($app->make('validator')),
                new \Entities\Vehicles\BrandsMutator, 
                $app->make('EntityTimestamps'),
                $app->make('EntityError')
            );
        });
    }

    public function branchoffices()
    {
        $this->app->bind('\Entities\BranchOffices\BranchOffices', function($app) {
            return new \Entities\BranchOffices\BranchOffices(
                new \Entities\BranchOffices\Models\BranchOffice,
                new \Entities\BranchOffices\BranchOfficesFilter,
                new \Entities\BranchOffices\BranchOfficesValidator($app->make('validator')),
                new \Entities\BranchOffices\BranchOfficesMutator, 
                $app->make('EntityTimestamps'),
                $app->make('EntityError')
            );
        });
    }

    public function parkinglogs()
    {
        $this->app->bind('\Entities\ParkingLogs\ParkingLogs', function($app) {
            return new \Entities\ParkingLogs\ParkingLogs(
                new \Entities\ParkingLogs\Models\ParkingLog,
                new \Entities\ParkingLogs\ParkingLogsFilter,
                new \Entities\ParkingLogs\ParkingLogsValidator($app->make('validator')),
                new \Entities\ParkingLogs\ParkingLogsMutator, 
                $app->make('EntityTimestamps'),
                $app->make('EntityError')
            );
        });
    }
}
