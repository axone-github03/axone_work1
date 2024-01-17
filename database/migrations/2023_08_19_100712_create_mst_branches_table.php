<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_branch', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('shortname');
            $table->bigInteger('company_id')->default(0);
            $table->string('address_line_1', 255)->nullable();
            $table->string('address_line_2', 255)->nullable();
            $table->string('pincode', 255)->nullable();
            $table->string('area', 255)->nullable();
            $table->bigInteger('country_id')->default(0);
            $table->bigInteger('state_id')->default(0);
            $table->bigInteger('city_id')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->string('source', 20)->nullable();
            $table->integer('entryby');
            $table->string('entryip',20);
            $table->integer('updateby');
            $table->string('updateip',20);
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
        Schema::dropIfExists('mst_branch');
    }
}
