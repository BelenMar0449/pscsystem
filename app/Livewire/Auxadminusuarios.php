<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Auxadminusuarios extends Component
{
    use WithPagination;

    public $search = '';
    protected $queryString = ['search' => ['except' => '']];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {

    $users = User::query()
        ->when($this->search, function ($query) {
            $query->where('name', 'like', '%'.$this->search.'%');

        })
        ->where('estatus','Activo')
        ->orderBy('name')
        ->paginate(10);

        return view('livewire.auxadminusuarios', [
            'users' => $users
        ]);
    }
}
