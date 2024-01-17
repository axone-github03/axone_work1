<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_logs_editer', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('company_id',20)->nullable();
            $table->string('log_type',255)->nullable();
            $table->string('field_name',255)->nullable();
            $table->string('old_value',255)->nullable();
            $table->string('new_value',255)->nullable();
            $table->string('transaction_type',255)->nullable();
            $table->integer('transaction_id');
            $table->string('description',255)->nullable();
            $table->string('source',255)->nullable();
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
        Schema::dropIfExists('master_logs_editer');
    }
}
