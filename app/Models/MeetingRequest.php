<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\MeetingRequestStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MeetingRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'availability_id', 'therapist_id', 'message', 'status'
    ];

    protected $casts = [
        'status' => MeetingRequestStatus::class,
    ];

    public function availability(): BelongsTo
    {
        return $this->belongsTo(Availability::class);
    }

    public function therapist(): BelongsTo
    {
        return $this->belongsTo(User::class, 'therapist_id');
    }
}
