<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Profiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->_apps();
        $this->_routes();
        $this->_groups();
        $this->_profiles();
        $this->_accesses();
    }

    public function _apps()
    {
        Schema::create('apps', function (Blueprint $table) {
            $table->increments('id');
            $table->char('name',35)->unique();
        });

        DB::table('apps')->insert([
            ['name' => 'mobile'],
            ['name' => 'backoffice']
        ]);
    }

    public function _routes()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->increments('id');
            $table->char('description',200);

            $table->integer('app_id')->unsigned();

            $table->foreign('app_id')
                  ->references('id')
                  ->on('apps')
                  ->onDelete('cascade');

            $table->boolean('delete')->default(false);

            $table->integer('created_id')->unsigned();
            $table->integer('updated_id')->unsigned();
            $table->integer('deleted_id')->unsigned();
        });
    }

    public function _groups()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',35)->unique();

            $table->boolean('active')->default(true);

            $table->boolean('delete')->default(false);

            $table->integer('created_id')->unsigned();
            $table->integer('updated_id')->unsigned();
            $table->integer('deleted_id')->unsigned();
        });

        DB::table('groups')->insert([
            [
                'name' => 'administrator',
                'delete' => false,
                'created_id' => 1,
                'updated_id' => 1,
                'deleted_id' => 1
            ]
        ]);
    }

    public function _profiles()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',35);

            $table->boolean('active')->default(true);

            $table->integer('group_id')->unsigned();

            $table->foreign('group_id')
                  ->references('id')
                  ->on('groups')
                  ->onDelete('cascade');

            $table->boolean('delete')->default(false);

            $table->integer('created_id')->unsigned();
            $table->integer('updated_id')->unsigned();
            $table->integer('deleted_id')->unsigned();
        });

        DB::table('profiles')->insert([
            [
                'name' => 'master',
                'group_id' => 1,
                'delete' => false,
                'created_id' => 1,
                'updated_id' => 1,
                'deleted_id' => 1
            ]
        ]);
    }

    public function _accesses()
    {
        Schema::create('accesses', function (Blueprint $table) {
            $table->increments('id');
            
            $table->boolean('active')->default(true);

            $table->integer('profile_id')->unsigned();

            $table->foreign('profile_id')
                  ->references('id')
                  ->on('profiles')
                  ->onDelete('cascade');

            $table->integer('route_id')->unsigned();

            $table->foreign('route_id')
                  ->references('id')
                  ->on('routes')
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
        Schema::drop('accesses');
        Schema::drop('profiles');
        Schema::drop('groups');
        Schema::drop('routes');
        Schema::drop('apps');
        //
    }
}
