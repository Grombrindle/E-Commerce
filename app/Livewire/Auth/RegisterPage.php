<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;


#[Title("Register")]
class RegisterPage extends Component
{
    public $name;
    public $email;
    public $password;

    public function save()
    {
        $attrs = $this->validate([
            "name" => ["required", "max:255", ""],
            "email" => ["required", "email", "unique:users", "max:255"],
            "password" => ["required", "max:255", "min:6"],
        ]);

        $user = User::create($attrs);

        Auth::login($user);

        return redirect()->intended();
    }

    public function render()
    {
        return view('livewire.auth.register-page');
    }
}
