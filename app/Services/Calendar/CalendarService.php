<?php

namespace App\Services\Calendar;

use App\Interfaces\Services\CalendarServiceInterface;
use App\Models\Availability;
use App\Models\Meeting;
use App\Enums\AvailabilityStatus;
use App\Enums\MeetingType;
use App\Enums\MeetingSubtype;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CalendarService implements CalendarServiceInterface
{
    public function availabilitiesForTherapist(int $therapistId, CarbonInterface $day): Collection
    {
        return Availability::query()
            ->where('therapist_id', $therapistId)
            ->whereDate('starts_at', $day->toDateString())
            ->orderBy('starts_at')
            ->get();
    }

    public function createAvailability(int $therapistId, CarbonInterface $startsAt, CarbonInterface $endsAt): Availability
    {
        if ($startsAt->gte($endsAt)) {
            throw ValidationException::withMessages(['ends_at' => 'End must be after start.']);
        }

        // Overlap check
        $overlap = Availability::query()
            ->where('therapist_id', $therapistId)
            ->where(function ($q) use ($startsAt, $endsAt) {
                $q->whereBetween('starts_at', [$startsAt, $endsAt])
                  ->orWhereBetween('ends_at', [$startsAt, $endsAt])
                  ->orWhere(function ($qq) use ($startsAt, $endsAt) {
                      $qq->where('starts_at', '<=', $startsAt)->where('ends_at', '>=', $endsAt);
                  });
            })->exists();

        if ($overlap) {
            throw ValidationException::withMessages(['starts_at' => 'Availability overlaps existing one.']);
        }

        return Availability::create([
            'therapist_id' => $therapistId,
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
            'status' => AvailabilityStatus::Empty,
        ]);
    }

    public function moveAvailability(int $availabilityId, CarbonInterface $startsAt, CarbonInterface $endsAt): Availability
    {
        $availability = Availability::findOrFail($availabilityId);

        if ($availability->status !== AvailabilityStatus::Empty) {
            throw ValidationException::withMessages(['status' => 'Only empty availability can be moved.']);
        }

        // Overlap check (exclude self)
        $overlap = Availability::query()
            ->where('therapist_id', $availability->therapist_id)
            ->where('id', '!=', $availabilityId)
            ->where(function ($q) use ($startsAt, $endsAt) {
                $q->whereBetween('starts_at', [$startsAt, $endsAt])
                  ->orWhereBetween('ends_at', [$startsAt, $endsAt])
                  ->orWhere(function ($qq) use ($startsAt, $endsAt) {
                      $qq->where('starts_at', '<=', $startsAt)->where('ends_at', '>=', $endsAt);
                  });
            })->exists();

        if ($overlap) {
            throw ValidationException::withMessages(['starts_at' => 'New time overlaps another availability.']);
        }

        $availability->update([
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
        ]);

        return $availability;
    }

    public function attachMeeting(int $availabilityId, array $data): Meeting
    {
        $availability = Availability::findOrFail($availabilityId);

        if ($availability->status !== AvailabilityStatus::Empty) {
            throw ValidationException::withMessages(['status' => 'Availability is not empty.']);
        }

        // Ensure meeting within bounds
        $startsAt = \Carbon\Carbon::parse($data['starts_at']);
        $endsAt = \Carbon\Carbon::parse($data['ends_at']);
        if ($startsAt->lt($availability->starts_at) || $endsAt->gt($availability->ends_at)) {
            throw ValidationException::withMessages(['starts_at' => 'Meeting must fit within availability window.']);
        }

        return DB::transaction(function () use ($availability, $data) {
            $meeting = Meeting::create([
                'availability_id' => $availability->id,
                'type' => $data['type'],
                'subtype' => $data['subtype'] ?? null,
                'title' => $data['title'] ?? null,
                'user_id' => $data['user_id'] ?? null,
                'starts_at' => $data['starts_at'],
                'ends_at' => $data['ends_at'],
            ]);

            $availability->update(['status' => \App\Enums\AvailabilityStatus::Booked]);

            return $meeting;
        });
    }
}
