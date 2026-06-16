<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Chama;  // ← This fixes the error
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        // Pass list of Chamas to the registration view (if you want a dropdown)
        $chamas = Chama::all();
        return view('auth.register', compact('chamas'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // Optionally validate chama_id if provided
            'chama_id' => ['nullable', 'exists:chamas,id'],
        ]);

        // Determine which Chama to assign:
        // 1. If user selected one, use that.
        // 2. Otherwise, get or create a default Chama.
        if ($request->filled('chama_id')) {
            $chama = Chama::findOrFail($request->chama_id);
        } else {
            $chama = Chama::first();
            if (!$chama) {
                $chama = Chama::create([
                    'name' => 'Default Chama',
                    'location' => 'Nairobi',
                    'currency' => 'KES',
                ]);
            }
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'member', // default role
            'chama_id' => $chama->id,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}