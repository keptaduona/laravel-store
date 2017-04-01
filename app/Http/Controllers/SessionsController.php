<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{

    public function destroy() {
        auth()->logout();

        return redirect('/');
    }

    public function store() {

        if(!auth()->attempt(request(['email', 'password']))) {
            return back()->withErrors([
                'message' => 'Patikrinkite įvestus duomenis ir bandykite dar kartą.'
            ]);
        }

        return redirect('/admin');
    }

}
