<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income', function (Blueprint $table) {
            $table->integer('organization_id')->unsigned();
            $table->integer('income_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->double('saleprice');
            $table->integer('amount');
            $table->integer('partner_id')->unsigned();
            $table->string('address');
            $table->integer('status_id')->unsigned();
            $table->integer('quotation_id')->unsigned()->default(0);
            $table->integer('invoice_id')->unsigned()->default(0);
            $table->integer('receipt_id')->unsigned()->default(0);
            $table->timestamps();
            $table->string('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('income');
    }
}
