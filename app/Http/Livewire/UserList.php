<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;

class UserList extends Component
{
    public $user;

    protected $rules = [
        'user.name' => 'required',
        'user.user' => 'required',
        'user.email' => 'required',
    ];

    public function render()
    {
        $users = User::all();
        return view('livewire.user-list', compact('users'));
    }

    public function edit(User $user)
    {
        $this->user = $user;

        $this->emit('showModal');
    }

    public function update()
    {
    }
}
