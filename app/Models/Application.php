<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'status', 'duration_months', 'principal_amount', 'reject_reason'
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    public static array $allowedStatuses = [
        self::STATUS_PENDING,
        self::STATUS_APPROVED,
        self::STATUS_REJECTED,
    ];

        
    // Define the accessor for the status field
    public function getStatusAttribute($value): string
    {
        return ucfirst($value);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

}
