<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->nullable()->constrained('loan_applications')->nullOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('chama_id')->constrained()->cascadeOnDelete();
            $table->decimal('principal_amount', 10, 2);
            $table->integer('repayment_months');
            $table->decimal('interest_rate', 5, 2)->default(0.00);
            $table->decimal('credit_score', 3, 1)->default(1.0);
            $table->string('status')->default('active'); // active, repaid, defaulted
            $table->decimal('outstanding_balance', 10, 2);
            $table->date('issue_date');
            $table->date('maturity_date');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['chama_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
