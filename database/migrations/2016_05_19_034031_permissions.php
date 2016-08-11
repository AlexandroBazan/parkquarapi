<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Permissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->integer('profile_id')->unsigned();

            $table->foreign('profile_id')
                  ->references('id')
                  ->on('profiles')
                  ->onDelete('cascade');

            $table->integer('branch_office_id')->unsigned();

            $table->foreign('branch_office_id')
                  ->references('id')
                  ->on('branch_offices')
                  ->onDelete('cascade');

            $table->boolean('active')->default(true);

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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
