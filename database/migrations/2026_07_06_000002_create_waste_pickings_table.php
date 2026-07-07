<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('waste_pickings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->unsignedBigInteger('partner_id')->nullable();
            $table->dateTime('date');
            $table->unsignedBigInteger('operating_unit_id')->nullable();
            $table->unsignedBigInteger('delivery_method_id')->nullable();
            $table->string('state')->default('draft');
            $table->unsignedBigInteger('purchase_transaction_id')->nullable();
            $table->unsignedBigInteger('sale_transaction_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('waste_pickings');
    }
};
