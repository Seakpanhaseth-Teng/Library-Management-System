<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fine extends Model
{
    use HasFactory;
    protected $fillable = [
        'borrowing_id',
        'amount',
        'paid',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'paid' => 'boolean',
            'paid_at' => 'datetime',
            'amount' => 'decimal:2',
        ];
    }

    public function borrowing(): BelongsTo
    {
        return $this->belongsTo(Borrowing::class);
    }
}
