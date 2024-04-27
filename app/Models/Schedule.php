<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id', 'start_date', 'end_date', 'actual_payment_amount',
        'expected_payment_amount', 'expected_payment_date', 'actual_payment_date',
    ];

    protected $dates = [
        'start_date', 'end_date', 'expected_payment_date', 'actual_payment_date',
    ];


    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

}
