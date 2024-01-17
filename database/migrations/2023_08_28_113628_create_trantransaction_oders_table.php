<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrantransactionOdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trantransactionOder', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_phone_number', 50)->nullable();
            $table->bigInteger('company_id')->default(0);
            $table->bigInteger('branch_id')->default(0);
            $table->string('shipping_address_line_1', 255)->nullable();
            $table->string('shipping_address_line_2', 255)->nullable();
            $table->string('shipping_pincode', 255)->nullable();
            $table->string('shipping_area', 255)->nullable();
            $table->bigInteger('shipping_country_id')->default(0);
            $table->bigInteger('shipping_state_id')->default(0);
            $table->bigInteger('shipping_city_id')->default(0);
            $table->Integer('total_item')->default(0);
            $table->Integer('total_qty')->default(0);
            $table->decimal('total_amount', 10, 2)->nullable(false)->default(0.00);
            $table->decimal('add_amount', 10, 2)->nullable(false)->default(0.00);
            $table->decimal('less_amount', 10, 2)->nullable(false)->default(0.00);
            $table->decimal('taxable_amount', 10, 2)->nullable(false)->default(0.00);
            $table->decimal('igst_per', 10, 2)->nullable(false)->default(0.00);
            $table->decimal('igst_amount', 10, 2)->nullable(false)->default(0.00);
            $table->decimal('cgst_per', 10, 2)->nullable(false)->default(0.00);
            $table->decimal('cgst_amount', 10, 2)->nullable(false)->default(0.00);
            $table->decimal('sgst_per', 10, 2)->nullable(false)->default(0.00);
            $table->decimal('sgst_amount', 10, 2)->nullable(false)->default(0.00);
            $table->decimal('roundup_amount', 10, 2)->nullable(false)->default(0.00);
            $table->decimal('net_amount', 10, 2)->nullable(false)->default(0.00);
            $table->tinyInteger('status')->default(1);
            $table->string('source', 20)->nullable();
            $table->integer('entryby')->default(0);
            $table->string('entryip', 20)->nullable();
            $table->integer('updateby')->default(0);
            $table->string('updateip', 20)->nullable();
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
        Schema::dropIfExists('trantransaction_oders');
    }
}
