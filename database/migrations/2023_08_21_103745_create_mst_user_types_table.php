<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstUserTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_user_type', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->nullable();
            $table->string('remark', 255)->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('mst_user_types');
    }
}
