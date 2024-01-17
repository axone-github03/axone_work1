<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTrantransactionOderToTrnOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trantransactionOder', function (Blueprint $table) {
            Schema::rename('trantransactionOder', 'trn_order');
        });

        Schema::table('trantransactionoderitems', function (Blueprint $table) {
            Schema::rename('trantransactionoderitems', 'trn_order_detail');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trantransactionOder', function (Blueprint $table) {
            Schema::rename('trn_order', 'trantransactionOder');
        });

        Schema::table('trantransactionoderitems', function (Blueprint $table) {
            Schema::rename('trn_order_detail', 'trantransactionoderitems');
        });
    }
}
