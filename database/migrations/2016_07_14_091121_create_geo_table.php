<?php

use App\Enums\Table;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(Table::GEO_COUNTRIES->value, function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('iso_2', 2)->unique()->nullable();
            $table->char('iso_3', 3)->unique()->nullable();
            $table->char('iso_number', 3)->unique()->nullable();
            $table->char('fips', 2)->unique()->nullable();
            $table->string('phone_code', 50)->nullable();
            $table->string('phone_code_e164', 50)->nullable();
            $table->string('name');
            $table->string('currency', 50)->nullable();
            $table->string('currency_code', 10)->nullable();
            $table->string('continent', 50)->nullable()->comment('benua');
            $table->string('timezone', 100)->nullable();
            $table->string('locale', 100)->nullable();
            $table->string('latitude', 50)->nullable();
            $table->string('longitude', 50)->nullable();
            $table->string('altitude', 50)->nullable();
            $table->text('geometry')->nullable();
            $table->timestamps(precision: 6);
            $table->softDeletes(precision: 6);

            $table->index('iso_2');
            $table->index('iso_3');
            $table->index('iso_number');
            $table->index('fips');
            $table->index('phone_code');
            $table->index('phone_code_e164');
            $table->index('name');
        });

        Schema::create(Table::GEO_PROVINCES->value, function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('country_id')->constrained(Table::GEO_COUNTRIES->value)->onDelete('restrict');
            $table->string('code', 100)->unique()->nullable();
            $table->string('name');
            $table->string('timezone', 100)->nullable();
            $table->string('locale', 100)->nullable();
            $table->string('latitude', 50)->nullable();
            $table->string('longitude', 50)->nullable();
            $table->string('altitude', 50)->nullable();
            $table->text('geometry')->nullable();
            $table->timestamps(precision: 6);
            $table->softDeletes(precision: 6);

            $table->index('code');
            $table->index('name');
        });

        Schema::create(Table::GEO_CITIES->value, function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('country_id')->constrained(Table::GEO_COUNTRIES->value)->onDelete('restrict');
            $table->foreignUuid('province_id')->constrained(Table::GEO_PROVINCES->value)->onDelete('restrict');
            $table->string('code', 100)->unique()->nullable();
            $table->string('name');
            $table->string('timezone', 100)->nullable();
            $table->string('locale', 100)->nullable();
            $table->string('latitude', 50)->nullable();
            $table->string('longitude', 50)->nullable();
            $table->string('altitude', 50)->nullable();
            $table->text('geometry')->nullable();
            $table->timestamps(precision: 6);
            $table->softDeletes(precision: 6);

            $table->index('code');
            $table->index('name');
        });

        Schema::create(Table::GEO_DISTRICTS->value, function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('country_id')->constrained(Table::GEO_COUNTRIES->value)->onDelete('restrict');
            $table->foreignUuid('province_id')->constrained(Table::GEO_PROVINCES->value)->onDelete('restrict');
            $table->foreignUuid('city_id')->constrained(Table::GEO_CITIES->value)->onDelete('restrict');
            $table->string('code', 100)->unique()->nullable();
            $table->string('name');
            $table->string('timezone', 100)->nullable();
            $table->string('locale', 100)->nullable();
            $table->string('latitude', 50)->nullable();
            $table->string('longitude', 50)->nullable();
            $table->string('altitude', 50)->nullable();
            $table->text('geometry')->nullable();
            $table->timestamps(precision: 6);
            $table->softDeletes(precision: 6);

            $table->index('code');
            $table->index('name');
        });

        Schema::create(Table::GEO_SUB_DISTRICTS->value, function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('country_id')->constrained(Table::GEO_COUNTRIES->value)->onDelete('restrict');
            $table->foreignUuid('province_id')->constrained(Table::GEO_PROVINCES->value)->onDelete('restrict');
            $table->foreignUuid('city_id')->constrained(Table::GEO_CITIES->value)->onDelete('restrict');
            $table->foreignUuid('district_id')->constrained(Table::GEO_DISTRICTS->value)->onDelete('restrict');
            $table->string('code', 100)->unique()->nullable();
            $table->string('name');
            $table->string('postal_code')->nullable();
            $table->string('timezone', 100)->nullable();
            $table->string('locale', 100)->nullable();
            $table->string('latitude', 50)->nullable();
            $table->string('longitude', 50)->nullable();
            $table->string('altitude', 50)->nullable();
            $table->text('geometry')->nullable();
            $table->timestamps(precision: 6);
            $table->softDeletes(precision: 6);

            $table->index('code');
            $table->index('name');
            $table->index('postal_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::withoutForeignKeyConstraints(function () {
            Schema::dropIfExists(Table::GEO_SUB_DISTRICTS->value);
            Schema::dropIfExists(Table::GEO_DISTRICTS->value);
            Schema::dropIfExists(Table::GEO_CITIES->value);
            Schema::dropIfExists(Table::GEO_PROVINCES->value);
            Schema::dropIfExists(Table::GEO_COUNTRIES->value);
        });
    }
};
