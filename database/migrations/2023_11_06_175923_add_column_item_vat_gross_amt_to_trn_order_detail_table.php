<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnItemVatGrossAmtToTrnOrderDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trn_order_detail', function (Blueprint $table) {
            $table->decimal('item_vat_gross_amt', 10, 2)->after('item_vat')->nullable(false)->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trn_order_detail', function (Blueprint $table) {
            //
        });
    }
}
