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
            $table->string('es_note');
            $table->integer('es_result');

            $table->date('test')->nullable();
            $table->integer('test_type');
            $table->string('test_note');
            $table->integer('test_result');

            $table->date('gd')->nullable();
            $table->string('gd_note');
            $table->integer('gd_result');

            $table->integer('result');
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
