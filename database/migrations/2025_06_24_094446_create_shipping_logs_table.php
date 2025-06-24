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
        Schema::create("shipping_logs", function (Blueprint $table) {
            $table->id();
            $table->foreignId("outbound_order_id")->constrained()->onDelete("cascade");
            $table->string("tracking_number")->nullable();
            $table->string("carrier")->nullable();
            $table->timestamp("shipped_at")->nullable();
            $table->timestamps();
        });
    {
        // Schema definition will be added by the script
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
        Schema::dropIfExists("shipping_logs");
    {
        // Schema drop will be added by the script
    }
};
