<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipment', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('tracking_id');
            $table->string('order_id');
            $table->string('f_country')->nullable();
            $table->string('f_name')->nullable();
            $table->string('f_companyname')->nullable();
            $table->string('f_address1')->nullable();
            $table->string('f_address2')->nullable();
            $table->string('f_postalcode')->nullable();
            $table->string('f_phonenumber')->nullable();
            $table->string('f_city')->nullable();
            $table->string('f_state')->nullable();
            $table->string('f_email')->nullable();
            $table->string('f_otherinfo')->nullable();

            $table->string('t_country')->nullable();
            $table->string('t_name')->nullable();
            $table->string('t_companyname')->nullable();
            $table->string('t_address1')->nullable();
            $table->string('t_address2')->nullable();
            $table->string('t_postalcode')->nullable();
            $table->string('t_phonenumber')->nullable();
            $table->string('t_city')->nullable();
            $table->string('t_state')->nullable();
            $table->string('t_email')->nullable();
            $table->string('t_otherinfo')->nullable();

            $table->string('package_type')->nullable();
            $table->string('merchandize_type')->nullable();
            $table->string('declared_value')->nullable();
            $table->string('extra_insurance')->nullable();
            $table->string('length')->nullable();
            $table->string('height')->nullable();
            $table->string('width')->nullable();
            $table->string('wieghtlb')->nullable();
            $table->string('commodity')->nullable();
            $table->string('pick_up_package')->nullable();
            $table->string('shipment_type')->nullable();
            $table->integer('accept_policy')->nullable();
            $table->string('product_details')->nullable();
            $table->string('status'); //0 - pending, 2 - Approved, 3 - In Process,4 - Arriving ,5 - Delivered,6 - Cancelled
            $table->integer('flag')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipment');
    }
}
