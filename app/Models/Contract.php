<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id', 'sign_date', 'start_date', 'end_date', 'interest_rate',
        'loan_term_months', 'principal', 'status'
    ];

    public const STATUS_ACTIVE = 'active';
    public const STATUS_TERMINATED = 'terminated';
    public const STATUS_EXPIRED = 'expired';

    public static array $allowedStatuses = [
        self::STATUS_ACTIVE,
        self::STATUS_TERMINATED,
        self::STATUS_EXPIRED,
    ];


    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
