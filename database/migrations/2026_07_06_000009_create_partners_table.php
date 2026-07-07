<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });

        Schema::table('waste_pickings', function (Blueprint $table) {
            $table->foreign('partner_id')->references('id')->on('partners')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('waste_pickings', function (Blueprint $table) {
            $table->dropForeign(['partner_id']);
        });
        Schema::dropIfExists('partners');
    }
};
