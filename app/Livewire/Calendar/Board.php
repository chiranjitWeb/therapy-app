<?php

namespace App\Livewire\Calendar;

use Livewire\Component;
use App\Interfaces\Services\CalendarServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Availability;

class Board extends Component
{
    public string $day;
    public array $slots = [];

    public function mount()
    {
        $this->day = Carbon::now()->toDateString();
        $this->loadDay();
    }

    public function loadDay()
    {
        /** @var CalendarServiceInterface $svc */
        $svc = app(\App\Interfaces\Services\CalendarServiceInterface::class);
        $items = $svc->availabilitiesForTherapist(Auth::id(), Carbon::parse($this->day));

        $this->slots = $items->map(fn(Availability $a) => [
            'id' => $a->id,
            'starts_at' => $a->starts_at?->toDateTimeString(),
            'ends_at' => $a->ends_at?->toDateTimeString(),
            'status' => $a->status->name,
        ])->toArray();
    }

    public function addAvailability(string $start, string $end)
    {
        $svc = app(\App\Interfaces\Services\CalendarServiceInterface::class);
        $svc->createAvailability(Auth::id(), Carbon::parse($start), Carbon::parse($end));
        $this->loadDay();
        $this->dispatch('toast', type:'success', message:'Availability added');
    }

    public function moveAvailability(int $id, string $start, string $end)
    {
        $svc = app(\App\Interfaces\Services\CalendarServiceInterface::class);
        $svc->moveAvailability($id, Carbon::parse($start), Carbon::parse($end));
        $this->loadDay();
        $this->dispatch('toast', type:'success', message:'Availability moved');
    }

    public function render()
    {
        return view('livewire.calendar.board')
            ->layout('layouts.app', ['title' => 'Calendar']);
    }
}
