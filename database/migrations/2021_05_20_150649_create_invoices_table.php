<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email', 100);
            $table->string('address');
            $table->string('address2')->nullable();
            $table->string('country');
            $table->string('state');
            $table->string('zip');
            $table->string('sub_total');
            $table->string('total');
            $table->string('discount')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
