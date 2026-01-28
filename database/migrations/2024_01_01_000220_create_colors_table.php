<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('colors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_kit_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('hex', 7);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('locked')->default(false);
            $table->timestamps();
            $table->index(['brand_kit_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('colors');
    }
};
