<?php

use App\Enums\Table;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(Table::PASSWORD_RESET_TOKENS->value, function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type')->default('phone')->comment('fill with phone,email');
            $table->string('target');
            $table->string('token');
            $table->timestamp('created_at', precision: 6)->nullable();
            $table->unsignedInteger('expires_interval')->default(30)->comment('expires in seconds');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Table::PASSWORD_RESET_TOKENS->value);
    }
};
