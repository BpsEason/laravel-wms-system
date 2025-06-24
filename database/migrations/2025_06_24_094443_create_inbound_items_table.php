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
        Schema::create("inbound_items", function (Blueprint $table) {
            $table->id();
            $table->foreignId("inbound_order_id")->constrained()->onDelete("cascade");
            $table->foreignId("product_id")->constrained()->onDelete("cascade");
            $table->unsignedInteger("expected_quantity");
            $table->unsignedInteger("received_quantity")->default(0);
            $table->foreignId("target_location_id")->nullable()->constrained("locations")->onDelete("set null");
            $table->timestamps();
        });
    {
        // Schema definition will be added by the script
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
        Schema::dropIfExists("inbound_items");
    {
        // Schema drop will be added by the script
    }
};
