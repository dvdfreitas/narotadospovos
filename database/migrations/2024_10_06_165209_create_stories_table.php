<?php

use App\Models\Category;
use App\Models\Story;
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
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('summary');
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->date('date');
            $table->boolean('visible')->default(true);
            $table->string('url')->nullable();
            $table->timestamps();
        });

        Schema::create('category_story', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Story::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Category::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};
