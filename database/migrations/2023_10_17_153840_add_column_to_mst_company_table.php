<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToMstCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mst_company', function (Blueprint $table) {
            $table->string('arabic_address_line_1', 255)->nullable()->after('address_line_1');
            $table->string('arabic_address_line_2', 255)->nullable()->after('address_line_1');
            $table->string('arabic_area', 255)->nullable()->after('address_line_1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mst_company', function (Blueprint $table) {
            //
        });
    }
}
