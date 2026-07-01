<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add stock and category to books
        Schema::table('books', function (Blueprint $table) {
            $table->string('category')->nullable()->after('description');
            $table->integer('stock')->default(1)->after('category');
        });

        // Create reservations table
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['waiting', 'notified', 'cancelled', 'fulfilled'])->default('waiting');
            $table->timestamp('notified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['category', 'stock']);
        });
    }
};
