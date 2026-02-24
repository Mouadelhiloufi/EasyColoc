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
        Schema::create('colocation_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('colocation_id')->constrained()->cascadeOnDelete();

            $table->string('role');
            $table->decimal('balance', 10, 2)->default(0);
            $table->integer('score')->default(0);
            $table->timestamp('left_at')->nullable();
            
            // whyyyyyyyyyy
            $table->string('status')->default('accepted');
            $table->unique(['user_id', 'colocation_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colocation_user');
    }
};
