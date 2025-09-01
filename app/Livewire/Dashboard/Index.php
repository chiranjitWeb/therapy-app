<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\User;
use App\Models\Addiction;
use Livewire\WithPagination;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    // public function getUsersProperty(): LengthAwarePaginator
    // {
    //     $users = User::query()
    //         ->whereHas('roles', fn($q) => $q->where('name','user'))
    //         ->when($this->search, function ($q) {
    //             $q->where(function ($qq) {
    //                 $qq->where('first_name','like', "%{$this->search}%")
    //                    ->orWhere('last_name','like', "%{$this->search}%")
    //                    ->orWhere('email','like', "%{$this->search}%");
    //             });
    //         })
    //         ->withCount('meetings')
    //         ->with('addiction')
    //         ->paginate(10);
        
    //     // Temporarily add this to debug
    //     dd($users->items());
        
    //     return $users;
    // }

    public function getUsersProperty(): LengthAwarePaginator
    {
        return User::query()
            ->whereHas('roles', fn($q) => $q->where('name', 'user'))
            ->when($this->search, function ($q) {
                $q->where(function ($qq) {
                    $qq->where('first_name', 'like', "%{$this->search}%")
                       ->orWhere('last_name', 'like', "%{$this->search}%")
                       ->orWhere('email', 'like', "%{$this->search}%")
                       ->orWhereHas('addiction', function ($q2) {
                           $q2->where('name', 'like', "%{$this->search}%");   ///also search with addiction name 
                       });
                });
            })
            ->withCount('meetings')
            ->with('addiction')
            ->paginate(1);
    }

    public function render()
    {
        $totalUsers = User::whereHas('roles', fn($q) => $q->where('name','user'))->count();
        $totalTherapists = User::whereHas('roles', fn($q) => $q->where('name','therapist'))->count();

        return view('livewire.dashboard.index', [
            'users' => $this->users,
            'totalUsers' => $totalUsers,
            'totalTherapists' => $totalTherapists,
        ])->layout('layouts.app', ['title' => 'Dashboard']);
    }
}
