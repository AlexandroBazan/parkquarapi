<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Vehicle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->_vehicle_brands();
        $this->_vehicle_models();
        $this->_vehicle_types();
        $this->_vehicle_colors();
        $this->_vehicles();
    }

    public function _vehicle_brands()
    {
        Schema::create('vehicle_brands', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name', 35)->unique();

            $table->boolean('delete')->default(false);

            $table->integer('created_id')->unsigned();
            $table->integer('updated_id')->unsigned();
            $table->integer('deleted_id')->unsigned();

            $table->foreign('created_id')
                  ->references('id')
                  ->on('timestamps')
                  ->onDelete('cascade');

            $table->foreign('updated_id')
                  ->references('id')
                  ->on('timestamps')
                  ->onDelete('cascade');

            $table->foreign('deleted_id')
                  ->references('id')
                  ->on('timestamps')
                  ->onDelete('cascade');
        });  
    }

    public function _vehicle_models()
    {
        Schema::create('vehicle_models', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name', 35)->unique();

            $table->integer('brand_id')->unsigned();

            $table->foreign('brand_id')
                  ->references('id')
                  ->on('vehicle_brands')
                  ->onDelete('cascade');

            $table->boolean('delete')->default(false);

            $table->integer('created_id')->unsigned();
            $table->integer('updated_id')->unsigned();
            $table->integer('deleted_id')->unsigned();

            $table->foreign('created_id')
                  ->references('id')
                  ->on('timestamps')
                  ->onDelete('cascade');

            $table->foreign('updated_id')
                  ->references('id')
                  ->on('timestamps')
                  ->onDelete('cascade');

            $table->foreign('deleted_id')
                  ->references('id')
                  ->on('timestamps')
                  ->onDelete('cascade');
        });  
    }

    public function _vehicle_colors()
    {
        Schema::create('vehicle_colors', function (Blueprint $table) {
            $table->increments('id');

            $table->char('name', 10)->unique();
            $table->string('hex', 7)->unique();
        });  

        DB::table('vehicle_colors')->insert([
            ['name' => 'blanco', 'hex' => '#ffffff'],
            ['name' => 'negro', 'hex' => '#2a2a2a'],
            ['name' => 'plomo', 'hex' => '#b6b6b6'],
            ['name' => 'marron', 'hex' => '#403027'],
            ['name' => 'rojo', 'hex' => '#c13d2f'],
            ['name' => 'naranja', 'hex' => '#e5813e'],
            ['name' => 'amarillo', 'hex' => '#e5c03e'],
            ['name' => 'verde', 'hex' => '#aace2c'],
            ['name' => 'violeta', 'hex' => '#39224e'],
            ['name' => 'azul', 'hex' => '#3e4ae5'],
            ['name' => 'celeste', 'hex' => '#3e9ce5'],
            ['name' => 'dorado', 'hex' => '#dbb658'],
        ]);
    }

    public function _vehicles()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->increments('id');

            $table->string('registation_plate', 7)->unique();

            $table->integer('customer_id')->unsigned();

            $table->foreign('customer_id')
                  ->references('id')
                  ->on('customers')
                  ->onDelete('cascade');

            $table->integer('model_id')->unsigned();

            $table->foreign('model_id')
                  ->references('id')
                  ->on('vehicle_models')
                  ->onDelete('cascade');

            $table->integer('type_id')->unsigned();

            $table->foreign('type_id')
                  ->references('id')
                  ->on('vehicle_types')
                  ->onDelete('cascade');

            $table->integer('color_id')->unsigned();

            $table->foreign('color_id')
                  ->references('id')
                  ->on('vehicle_colors')
                  ->onDelete('cascade');

            $table->boolean('delete')->default(false);

            $table->integer('created_id')->unsigned();
            $table->integer('updated_id')->unsigned();
            $table->integer('deleted_id')->unsigned();

            $table->foreign('created_id')
                  ->references('id')
                  ->on('timestamps')
                  ->onDelete('cascade');

            $table->foreign('updated_id')
                  ->references('id')
                  ->on('timestamps')
                  ->onDelete('cascade');

            $table->foreign('deleted_id')
                  ->references('id')
                  ->on('timestamps')
                  ->onDelete('cascade');
        });  
    }

    public function _vehicle_types()
    {
        Schema::create('vehicle_types', function (Blueprint $table) {
            $table->increments('id');

            $table->char('name', 15)->unique();
        });  

        DB::table('vehicle_types')->insert([
            ['name' => 'automovil'],
            ['name' => 'camioneta'],
            ['name' => 'motocicleta'],
            ['name' => 'taxi'],
            ['name' => 'mototaxi']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('vehicles');
        Schema::drop('vehicle_types');
        Schema::drop('vehicle_colors');
        Schema::drop('vehicle_models');
        Schema::drop('vehicle_brands');
    }
}
