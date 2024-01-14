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
        Schema::create('denormalized_affiliate_code_clicks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliate_code_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained();
            $table->string('affiliate_code');
            $table->unsignedInteger('clicks_count')->default(0);
            $table->unsignedInteger('conversions_count')->default(0);

            // Add indexes on the foreign keys
            $table->index('user_id');
            $table->index('affiliate_code_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('denormalized_affiliate_code_clicks');
    }
};
