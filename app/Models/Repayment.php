<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Repayment extends Model
{
    protected $fillable = [
        'loan_id',
    'repayment_amount',
    'repayment_date',
    'remaining_balance',
    'is_late',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'date',
    ];

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }
}
