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
        Schema::create("audit_logs", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->nullable()->constrained("users")->onDelete("set null");
            $table->string("event"); // e.g., created, updated, deleted, inbound_completed, outbound_shipped
            $table->morphs("auditable"); // auditable_id, auditable_type
            $table->text("old_values")->nullable();
            $table->text("new_values")->nullable();
            $table->text("ip_address")->nullable();
            $table->text("user_agent")->nullable();
            $table->timestamps();
        });
    {
        // Schema definition will be added by the script
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
        Schema::dropIfExists("audit_logs");
    {
        // Schema drop will be added by the script
    }
};
