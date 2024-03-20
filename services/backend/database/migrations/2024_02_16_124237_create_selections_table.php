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
        Schema::create('selections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();

            $table->date('es')->nullable();
            $table->string('es_note')->nullable();
            $table->integer('es_result')->default(0);

            $table->date('test')->nullable();
            $table->integer('test_type')->nullable();
            $table->string('test_note')->nullable();
            $table->integer('test_result')->default(0);

            $table->date('gd')->nullable();
            $table->string('gd_note')->nullable();
            $table->integer('gd_result')->default(0);

            $table->integer('result')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selections');
    }
};
