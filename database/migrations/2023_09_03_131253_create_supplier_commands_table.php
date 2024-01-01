<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('supplier_commands', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pharmacist_id')->nullable();
            $table->string('status')->default('pending');
            $table->decimal('total_price', 10, 2)->nullable();
            $table->timestamp('arrived_at')->nullable();
            $table->timestamps();
            $table->foreign('pharmacist_id')->references('id')->on('pharmacists')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_commands');
    }
};
