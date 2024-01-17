<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrantransactionOderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trantransactionoderitems', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_id')->default(0);
            $table->bigInteger('branch_id')->default(0);
            $table->bigInteger('order_id')->default(0);
            $table->string('item_name')->nullable();
            $table->string('item_design_no')->nullable();
            $table->decimal('item_gold_ctc', 10, 2)->nullable(false)->default(0.00);
            $table->decimal('item_diamond_ctc', 10, 2)->nullable(false)->default(0.00);
            $table->decimal('item_weight', 10, 2)->nullable(false)->default(0.00);
            $table->decimal('item_amount_aed', 10, 2)->nullable(false)->default(0.00);
            $table->decimal('item_price', 10, 2)->nullable(false)->default(0.00);
            $table->integer('item_qty')->default(0);
            $table->decimal('disc_per', 10, 2)->nullable(false)->default(0.00);
            $table->decimal('disc_amount', 10, 2)->nullable(false)->default(0.00);
            $table->decimal('gross_amount', 10, 2)->nullable(false)->default(0.00);
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
        Schema::dropIfExists('trantransaction_oder_items');
    }
}
