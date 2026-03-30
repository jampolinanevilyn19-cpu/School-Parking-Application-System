<?php
// File: app/Http/Middleware/UniqueEmailValidation.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UniqueEmailValidation
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->isMethod('post') && $request->has('email')) {
            $users = Session::get('users', []);
            $exists = collect($users)->contains('email', $request->email);
            
            if ($exists) {
                return back()->withErrors(['email' => 'The email has already been taken.'])->withInput();
            }
        }
        
        return $next($request);
    }
}