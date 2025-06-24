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
        Schema::create("warehouses", function (Blueprint $table) {
            $table->id();
            $table->string("name")->unique();
            $table->string("address")->nullable();
            $table->timestamps();
        });
    {
        // Schema definition will be added by the script
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
        Schema::dropIfExists("warehouses");
    {
        // Schema drop will be added by the script
    }
};
