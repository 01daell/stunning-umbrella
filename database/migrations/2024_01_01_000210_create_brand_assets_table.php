<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('brand_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_kit_id')->constrained()->cascadeOnDelete();
            $table->string('type');
            $table->string('path');
            $table->string('mime');
            $table->unsignedBigInteger('size');
            $table->string('original_name');
            $table->timestamps();
            $table->index(['brand_kit_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brand_assets');
    }
};
