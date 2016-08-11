<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    protected $vehicles_brands = ["Acura", "Alfa Romeo", "AMC", "Aston Martin", "Audi", "Avanti", "Bentley", "BMW", "Buick", "Cadillac", "Chevrolet", "Chrysler", "Daewoo", "Daihatsu", "Datsun", "DeLorean", "Dodge", "Eagle", "Ferrari", "FIAT", "Fisker", "Ford", "Freightliner", "Geo", "GMC", "Honda", "HUMMER", "Hyundai", "Infiniti", "Isuzu", "Jaguar", "Jeep", "Kia", "Lamborghini", "Lancia", "Land Rover", "Lexus", "Lincoln", "Lotus", "Maserati", "Maybach", "Mazda", "McLaren", "Mercedes-Benz", "Mercury", "Merkur", "MINI", "Mitsubishi", "Nissan", "Oldsmobile", "Peugeot", "Plymouth", "Pontiac", "Porsche", "RAM", "Renault", "Rolls-Royce", "Saab", "Saturn", "Scion", "smart", "SRT", "Sterling", "Subaru", "Suzuki", "Tesla", "Toyota", "Triumph", "Volkswagen", "Volvo", "Yugo"];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //actory(Impark\Filter\test\User::class, 300)->create();
        //factory(Impark\Filter\test\Group::class, 15)->create();
        //factory(Impark\Filter\test\Profile::class, 30)->create();
        //factory(Impark\Filter\test\BranchOffice::class, 6)->create();
        ////factory(Impark\Filter\test\Permision::class, 80)->create();
        ////factory(Entities\Routes\Models\Route::class, 40)->create();
        //factory(Entities\Accesses\Models\Access::class, 150)->create();
        //factory(Entities\Customers\Models\Customer::class, 50)->create();
        
        //$this->vehiclesBrands();
        
        //factory(Entities\Vehicles\Models\Model::class, 150)->create();
        factory(Entities\Vehicles\Models\Vehicle::class, 150)->create();

    }

    public function vehiclesBrands()
    {
        foreach ($this->vehicles_brands as $key => $value) {
            $timestamps = factory(Impark\Filter\test\Timestamp::class)->create()->id;

            $brand = [
                'name'       => $value,
                'created_id' => $timestamps,
                'updated_id' => $timestamps,
                'deleted_id' => $timestamps,
            ];

            app('db')->table('vehicle_brands')
                     ->insert($brand);
        }
    }
}
