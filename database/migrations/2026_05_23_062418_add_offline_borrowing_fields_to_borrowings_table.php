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
        Schema::table('borrowings', function (Blueprint $table) {
            // Make user_id nullable to support offline borrowing
            $table->foreignId('user_id')->nullable()->change();
            
            // Add borrower_name for offline borrowers
            $table->string('borrower_name')->nullable()->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            // Remove borrower_name
            $table->dropColumn('borrower_name');
            
            // Make user_id not nullable again
            $table->foreignId('user_id')->nullable(false)->change();
        });
    }
};
