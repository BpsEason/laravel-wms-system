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
        Schema::create("locations", function (Blueprint $table) {
            $table->id();
            $table->foreignId("warehouse_id")->constrained()->onDelete("cascade");
            $table->string("aisle");
            $table->string("rack");
            $table->string("shelf");
            $table->string("bin");
            $table->string("code")->unique();
            $table->timestamps();
        });
    {
        // Schema definition will be added by the script
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
        Schema::dropIfExists("locations");
    {
        // Schema drop will be added by the script
    }
};
