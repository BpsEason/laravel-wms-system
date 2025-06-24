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
        Schema::create("outbound_orders", function (Blueprint $table) {
            $table->id();
            $table->string("order_number")->unique();
            $table->foreignId("warehouse_id")->constrained()->onDelete("cascade");
            $table->string("status")->default("pending"); // e.g., pending, picked, shipped, cancelled
            $table->string("customer_name")->nullable();
            $table->string("shipping_address")->nullable();
            $table->timestamps();
        });
    {
        // Schema definition will be added by the script
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
        Schema::dropIfExists("outbound_orders");
    {
        // Schema drop will be added by the script
    }
};
