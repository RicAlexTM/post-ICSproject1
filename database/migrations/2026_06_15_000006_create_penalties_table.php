<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penalties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('chama_id')->constrained()->cascadeOnDelete();
            $table->string('penalty_type'); // e.g. late_contribution, default, meeting_absence
            $table->decimal('amount', 10, 2);
            $table->string('billing_cycle'); // e.g. '2026-06'
            $table->string('status')->default('unpaid'); // unpaid, paid
            $table->timestamp('assessed_at')->useCurrent();
            $table->timestamp('cleared_at')->nullable();
            $table->timestamps();

            $table->index(['chama_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penalties');
    }
};
