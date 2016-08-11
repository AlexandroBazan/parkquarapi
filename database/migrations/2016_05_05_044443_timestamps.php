<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Carbon\Carbon;

class Timestamps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->_users();
        $this->_timestamps();
    }

    public function _users()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 14);
            $table->string('password', 60);

            $table->boolean('active')->default(false);

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

        //
        $hash = new \Illuminate\Hashing\BcryptHasher;
        
        DB::table('users')->insert([
            [
                'username' => 'admin',
                'password' => $hash->make('05052016'),
                'person_id' => 1,
                'delete' => false,
                'created_id' => 1,
                'updated_id' => 1,
                'deleted_id' => 1
            ]
        ]);
    }

    public function _timestamps()
    {
        Schema::create('timestamps', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('time');
            $table->enum('type', ['create','update','delete']);

            $table->integer('user_id')->unsigned();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->integer('app_id')->unsigned();

            $table->foreign('app_id')
                  ->references('id')
                  ->on('apps')
                  ->onDelete('cascade');

            $table->ipAddress('ip');
        });

        DB::table('timestamps')->insert([
            [
                'user_id' => 1,
                'app_id' => 1,
                'ip' => '127.0.0.1',
                'time' => Carbon::now()
            ]
        ]);

        // agrega los timestamps pendientes
        
        $tablas = [
            'users',
            'emails',
            'addresses',
            'phones',
            'persons',
            'accesses',
            'profiles',
            'groups',
            'routes'
        ];

        foreach ($tablas as $key => $value) {
            Schema::table($value, function ($table) {
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

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('timestamps');
        Schema::drop('users');
    }
}
