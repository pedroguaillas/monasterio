<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserList extends Component
{
    public $user;

    protected $rules = [
        'user.name' => 'required',
        'user.user' => 'required',
        'user.email' => 'required',
        // 'user.password' => 'min:6',
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
        // if (isset($this->user->password)) {
        //     $this->user->password = Hash::make($this->user->password);
        // }

        if ($this->user->save()) {
            $this->emit('closeModal');
        }
    }
}
