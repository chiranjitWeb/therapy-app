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
    public $comingsoon ="Coming Soon";

    public function mount()
    {
        
        //$this->day = Carbon::now()->toDateString();
        //$this->loadDay();
    }

    public function loadDay()
    {
        $svc = app(CalendarServiceInterface::class);
        $items = $svc->availabilitiesForTherapist(Auth::id(), Carbon::parse($this->day));

        $this->slots = $items->map(fn(Availability $a) => [
            'id' => $a->id,
            'starts_at' => $a->starts_at?->toDateTimeString(),
            'ends_at' => $a->ends_at?->toDateTimeString(),
            'status' => $a->status->name,
        ])->toArray();
    }

    public function render()
    {
        return view('livewire.calendar.index');
    }
}
