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
        $credentials = $this->validate([
            "email" => ["required", "email", "max:255", "exists:users"],
            "password" => ["required", "max:255", "min:6"],
        ]);

        if (Auth::attempt($credentials)) {
            return redirect()->intended();
        }

        session()->flash("error", "Invalid credentials");
        return;
    }


    public function render()
    {
        return view('livewire.auth.login-page');
    }
}
