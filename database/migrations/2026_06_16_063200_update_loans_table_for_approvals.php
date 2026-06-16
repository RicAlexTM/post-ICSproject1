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
        Schema::table('loans', function (Blueprint $table) {
            // Check if columns already exist before adding them
            
            if (!Schema::hasColumn('loans', 'credit_score')) {
                $table->decimal('credit_score', 3, 1)->nullable()->after('status');
            }

            if (!Schema::hasColumn('loans', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable()->after('credit_score');
            }

            if (!Schema::hasColumn('loans', 'approved_by')) {
                $table->foreignId('approved_by')->nullable()->after('rejection_reason')->constrained('users')->nullOnDelete();
            }

            if (!Schema::hasColumn('loans', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('approved_by');
            }

            // Using 'amount' column since your table uses that instead of 'principal_amount'
            if (!Schema::hasColumn('loans', 'outstanding_balance')) {
                $table->decimal('outstanding_balance', 10, 2)->default(0)->after('amount');
            }

            if (!Schema::hasColumn('loans', 'maturity_date')) {
                $table->date('maturity_date')->nullable()->after('term_months');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $columns = ['credit_score', 'rejection_reason', 'approved_by', 'approved_at', 'outstanding_balance', 'maturity_date'];
            
            foreach ($columns as $col) {
                if (Schema::hasColumn('loans', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};