<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_company', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('shortname');
            $table->string('address_line_1', 255)->nullable();
            $table->string('address_line_2', 255)->nullable();
            $table->string('pincode', 255)->nullable();
            $table->string('area', 255)->nullable();
            $table->bigInteger('country_id')->default(0);
            $table->bigInteger('state_id')->default(0);
            $table->bigInteger('city_id')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->string('source', 20)->nullable();
            $table->integer('entry_by');
            $table->string('entry_ip', 20)->nullable();
            $table->integer('update_by');
            $table->string('update_ip', 20)->nullable();
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
        Schema::dropIfExists('mst_company');
    }
}
