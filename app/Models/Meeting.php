<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\MeetingType;
use App\Enums\MeetingSubtype;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'availability_id', 'type', 'subtype', 'title', 'user_id', 'starts_at', 'ends_at'
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'type' => MeetingType::class,
        'subtype' => MeetingSubtype::class,
    ];

    public function availability(): BelongsTo
    {
        return $this->belongsTo(Availability::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
