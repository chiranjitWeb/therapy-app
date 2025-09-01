<?php

namespace App\Interfaces\Services;

use App\Models\Availability;
use App\Models\Meeting;
use Illuminate\Support\Collection;
use Carbon\CarbonInterface;

interface CalendarServiceInterface
{
    /** @return Collection<int, Availability> */
    public function availabilitiesForTherapist(int $therapistId, CarbonInterface $day): Collection;

    public function createAvailability(int $therapistId, CarbonInterface $startsAt, CarbonInterface $endsAt): Availability;

    public function moveAvailability(int $availabilityId, CarbonInterface $startsAt, CarbonInterface $endsAt): Availability;

    public function attachMeeting(int $availabilityId, array $data): Meeting;
}
