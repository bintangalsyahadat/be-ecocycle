<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('waste_moves', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->string('type'); // incoming, outgoing
            $table->foreignId('category_id')->constrained('waste_categories')->restrictOnDelete();
            $table->unsignedBigInteger('operating_unit_id')->nullable();
            $table->decimal('quantity', 12, 2)->nullable()->default(0);
            $table->decimal('valid_qty', 12, 2)->nullable()->default(0);
            $table->string('state')->default('forecasted'); // forecasted, done, cancel
            $table->foreignId('waste_picking_id')->nullable()->constrained('waste_pickings')->nullOnDelete();
            $table->unsignedBigInteger('purchase_transaction_item_id')->nullable();
            $table->unsignedBigInteger('sale_transaction_item_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('waste_moves');
    }
};
