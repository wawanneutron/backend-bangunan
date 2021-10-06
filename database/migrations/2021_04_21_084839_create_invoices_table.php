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
            $table->text('invoice');
            $table->unsignedBigInteger('customer_id');
            $table->string('name');
            $table->bigInteger('phone');
            $table->integer('province');
            $table->integer('city');
            $table->text('address');
            $table->text('note')->nullable();
            $table->enum('status', ['pending', 'payment-success', 'success', 'process', 'shipping', 'failed', 'expired']);
            $table->string('snap_token')->nullable();
            $table->bigInteger('grand_total');
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
        Schema::dropIfExists('invoices');
    }
}
