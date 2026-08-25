<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('category'); // maintenance|fuel|insurance|cleaning|repair|tax|marketing|salary|utilities|other
            $table->foreignId('car_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('amount', 10, 2);
            $table->text('description');
            $table->date('expense_date');
            $table->string('receipt_path')->nullable();
            $table->string('paid_by')->nullable();
            $table->string('vendor')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
