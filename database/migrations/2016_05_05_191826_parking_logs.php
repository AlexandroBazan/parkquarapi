<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ParkingLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->_branch_offices();
        $this->_parking_logs();
    }

    public function _branch_offices()
    {
        Schema::create('branch_offices', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name', 35);

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

    public function _parking_logs()
    {
        Schema::create('parking_logs', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('vehicle_id')->unsigned();

            $table->foreign('vehicle_id')
                  ->references('id')
                  ->on('vehicles')
                  ->onDelete('cascade');

            $table->integer('branch_office_id')->unsigned();

            $table->foreign('branch_office_id')
                  ->references('id')
                  ->on('branch_offices')
                  ->onDelete('cascade');

            $table->boolean('egress')->default(false);

            $table->string('ingress_image', 200);

            $table->datetime('ingress_at');
            
            $table->integer('ingress_user')->unsigned();
            $table->foreign('ingress_user')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->datetime('egress_at');
            $table->integer('egress_user')->unsigned();
            $table->foreign('egress_user')
                  ->references('id')
                  ->on('users')
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
        Schema::drop('branch_offices');
        Schema::drop('parking_logs');
    }
}
