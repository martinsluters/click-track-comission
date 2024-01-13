<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
    * Run the migrations.
    */
    public function up(): void
    {
        Schema::create('affiliate_code_click_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliate_code_id')->constrained()->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent();

            // Add indexes on the foreign keys
            $table->index('affiliate_code_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_code_click_events');
    }
};
