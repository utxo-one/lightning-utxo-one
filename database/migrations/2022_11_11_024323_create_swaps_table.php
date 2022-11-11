<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('swaps', function (Blueprint $table) {
            $table->id();
            $table->text('uuid');
            $table->string('type');
            $table->string('status');
            $table->integer('amount');
            $table->integer('fee');
            $table->string('r_hash')->nullable();
            $table->text('payment_request')->nullable();
            $table->text('address')->nullable();
            $table->text('txid')->nullable();
            $table->timestamps();
            $table->timestamp('completed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('swaps');
    }
};
