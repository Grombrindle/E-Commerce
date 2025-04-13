<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Login")]
class LoginPage extends Component
{
    public $email;
    public $password;


    public function save()
    {
        $user = $this->validate([
            "email" => ["required", "email", "unique:users", "max:255",],
            "password" => ["required", "max:255", "min:6"],
        ]);
        if (Auth::attempt($user)) {
            Auth::login($user);
            return redirect()->intended();
        } else {
            session()->flash("error", "invalid info");
            return;
        }
    }

    public function render()
    {
        return view('livewire.auth.login-page');
    }
}
