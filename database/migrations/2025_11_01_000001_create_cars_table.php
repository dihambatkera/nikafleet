<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // custom display name
            $table->string('plate_number')->unique();
            $table->string('brand');
            $table->string('model');
            $table->unsignedSmallInteger('year');
            $table->string('color');
            $table->enum('type', ['sedan', 'suv', 'mpv', 'pickup', 'van', 'hatchback']);
            $table->enum('transmission', ['auto', 'manual']);
            $table->unsignedTinyInteger('seats');
            $table->enum('fuel_type', ['petrol', 'diesel', 'hybrid', 'electric']);
            $table->decimal('price_per_day', 10, 2);
            $table->decimal('price_per_week', 10, 2)->nullable();
            $table->decimal('deposit_amount', 10, 2)->default(0);
            $table->unsignedInteger('mileage')->default(0);
            $table->date('last_service_date')->nullable();
            $table->string('location')->default('Rawang, Selangor');
            $table->enum('status', ['available', 'rented', 'maintenance', 'hidden'])->default('available');
            $table->boolean('featured')->default(false);
            $table->text('description')->nullable();
            $table->string('availability_note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
