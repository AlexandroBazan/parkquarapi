<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Customer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->_customers();
    }

    public function _customers()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('person_id')->unsigned();

            $table->foreign('person_id')
                  ->references('id')
                  ->on('persons')
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('customers');
    }
}
