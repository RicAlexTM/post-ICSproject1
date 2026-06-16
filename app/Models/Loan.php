<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Loan extends Model
{
    protected $fillable = [
        'user_id',
        'chama_id',
        'principal_amount',
        'interest_rate',
        'repayment_months',
        'status',
        'credit_score',
        'rejection_reason',
        'approved_by',
        'approved_at',
        'outstanding_balance',
        'maturity_date',
        // other fields
    ];

    protected $casts = [
        'principal_amount' => 'decimal:2',
        'interest_rate' => 'decimal:2',
        'credit_score' => 'decimal:1',
        'outstanding_balance' => 'decimal:2',
        'approved_at' => 'datetime',
        'maturity_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chama()
    {
        return $this->belongsTo(Chama::class);
    }

    public function repayments()
    {
        return $this->hasMany(Repayment::class);
    }

    public function amortizationSchedule()
    {
        return $this->hasMany(AmortizationSchedule::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}