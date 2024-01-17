<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToMstBranchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mst_branch', function (Blueprint $table) {
            $table->string('arabic_address_line_1', 255)->nullable()->after('address_line_2');
            $table->string('arabic_address_line_2', 255)->nullable();
            $table->string('arabic_area', 255)->nullable()->after('area');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mst_branch', function (Blueprint $table) {
            //
        });
    }
}
