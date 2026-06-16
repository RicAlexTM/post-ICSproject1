<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fine extends Model
{
    protected $fillable = [
        'user_id',
        'chama_id',
        'amount',
        'type',
        'status',
        'due_date',
        'paid_at',
        'description',
    ];

    protected $casts = [
        'late_penalty_flat' => 'decimal:2',
    'interest_rate_pct' => 'decimal:2',
    'min_credit_score' => 'decimal:1',
    'savings_weight' => 'decimal:2',
    'attendance_weight' => 'decimal:2',
    'repayment_weight' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function chama(): BelongsTo
    {
        return $this->belongsTo(Chama::class);
    }
}
