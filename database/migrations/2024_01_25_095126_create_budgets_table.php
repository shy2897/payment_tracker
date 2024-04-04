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
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->string('year');
            $table->enum('category', ['product', 'annual', 'change', 'capex', 'opex']);
            $table->integer('budget')->default(0);
            $table->integer('balance')->default(0)->signed();
            $table->integer('subtraction')->default(0);
            $table->string('b_edited_by')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
