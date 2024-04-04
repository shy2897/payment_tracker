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
        Schema::create('capexes', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->unique();
            $table->string('invoice_date')->nullable();
            $table->string('deadline_date')->nullable();
            $table->string('description');
            $table->string('file')->nullable();
            $table->string('currency');
            $table->string('vendor');
            $table->integer('units')->unsigned()->nullable();
            $table->integer('amount')->unsigned();
            $table->integer('rate')->unsigned();
            $table->integer('tds')->unsigned()->nullable();
            $table->integer('amc')->unsigned()->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved');
            $table->string('rejection_reason')->nullable();
            $table->string('comment')->nullable();
            $table->string('usd_rate')->nullable();
            $table->string('prev_currency')->nullable();
            $table->string('prev_amount')->nullable();
            $table->string('created_by')->nullable();
            $table->string('edited_by')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('sub_category')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capexes');
    }
};
