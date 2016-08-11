<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Carbon\Carbon;

class Person extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->_persons();
        $this->_phones();
        $this->_addresses();
        $this->_emails();

    }

    private function _persons()
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->increments('id');
            $table->char('dni',8)->unique();

            $table->string('firstname', 35);
            $table->string('lastname', 35);

            $table->enum('gender', ['hombre', 'mujer']);

            $table->string('image', 200);

            $table->date('birthday');

            $table->boolean('delete')->default(false);

            $table->integer('created_id')->unsigned();
            $table->integer('updated_id')->unsigned();
            $table->integer('deleted_id')->unsigned();
        });

        DB::table('persons')->insert([
            [
                'dni' => '00000000',
                'firstname' => 'none',
                'lastname' => 'none',
                'birthday' => Carbon::now(),
                'image' => 'none',
                'gender' => 'hombre',
                'delete' => false,
                'created_id' => 1,
                'updated_id' => 1,
                'deleted_id' => 1
            ],
            [
                'dni' => '71486566',
                'firstname' => 'alexandro',
                'lastname' => 'bazan ladines',
                'birthday' => '1991-11-28',
                'image' => 'none',
                'gender' => 'hombre',
                'delete' => false,
                'created_id' => 1,
                'updated_id' => 1,
                'deleted_id' => 1
            ],
        ]);

    }

    private function _phones()
    {
        Schema::create('phone_types', function (Blueprint $table) {

            $table->engine = "InnoDB";
            $table->increments('id');
            $table->char('name', 7)->unique();
        });

        //crear tipos de telefono
        
        DB::table('phone_types')->insert([
            ['name' => 'casa'],
            ['name' => 'celular'],
            ['name' => 'oficina']
        ]);

        Schema::create('phones', function (Blueprint $table) {

            $table->engine = "InnoDB";
            $table->increments('id');
            $table->string('number',15)->unique();

            $table->integer('type_id')->unsigned();

            $table->foreign('type_id')
                  ->references('id')
                  ->on('phone_types')
                  ->onDelete('cascade');

            $table->integer('person_id')->unsigned();

            $table->foreign('person_id')
                  ->references('id')
                  ->on('persons')
                  ->onDelete('cascade');

            $table->boolean('delete')->default(false);

            $table->integer('created_id')->unsigned();
            $table->integer('updated_id')->unsigned();
            $table->integer('deleted_id')->unsigned();

        });

    }

    private function _addresses()
    {
        Schema::create('addresses', function (Blueprint $table) {

            $table->engine = "InnoDB";
            $table->increments('id');
            $table->string('description', 200);

            $table->integer('person_id')->unsigned();

            $table->foreign('person_id')
                  ->references('id')
                  ->on('persons')
                  ->onDelete('cascade');

            $table->boolean('delete')->default(false);

            $table->integer('created_id')->unsigned();
            $table->integer('updated_id')->unsigned();
            $table->integer('deleted_id')->unsigned();
        });

    }

    private function _emails()
    {
        Schema::create('emails', function (Blueprint $table) {

            $table->engine = "InnoDB";
            $table->increments('id');
            $table->string('description', 320);
            $table->string('username', 64);
            $table->string('domain', 255);

            $table->integer('person_id')->unsigned();

            $table->foreign('person_id')
                  ->references('id')
                  ->on('persons')
                  ->onDelete('cascade');

            $table->boolean('delete')->default(false);

            $table->integer('created_id')->unsigned();
            $table->integer('updated_id')->unsigned();
            $table->integer('deleted_id')->unsigned();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('emails');
        Schema::drop('addresses');
        Schema::drop('phones');
        Schema::drop('phone_types');
        Schema::drop('persons');
    }
}
