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
        Schema::create("inventories", function (Blueprint $table) {
            $table->id();
            $table->foreignId("product_id")->constrained()->onDelete("cascade");
            $table->foreignId("location_id")->constrained()->onDelete("cascade");
            $table->unsignedInteger("quantity");
            $table->timestamps();
            $table->unique(["product_id", "location_id"]);
        });
    {
        // Schema definition will be added by the script
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
        Schema::dropIfExists("inventories");
    {
        // Schema drop will be added by the script
    }
};
