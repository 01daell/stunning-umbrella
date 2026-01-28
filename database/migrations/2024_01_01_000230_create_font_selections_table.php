<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('font_selections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_kit_id')->constrained()->cascadeOnDelete();
            $table->string('heading_font');
            $table->string('body_font');
            $table->json('heading_weights')->nullable();
            $table->json('body_weights')->nullable();
            $table->string('source');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('font_selections');
    }
};
