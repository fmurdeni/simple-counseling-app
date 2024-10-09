<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

use App\Models\Role;
use App\Models\UserCustomField;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'roles' => 'required|array', // Array of role IDs
            'roles.*' => 'exists:roles,id', // Ensure each role ID exists in roles table
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => preg_replace('/\D/', '', $request->phone),
        ]);

        // Save the role
        $user->roles()->attach($validatedData['roles']);

        // save custom fields
        $fields = UserCustomField::fields();
        if (!empty($fields)) {
            foreach ($fields as $field) {
                UserCustomField::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'field_key' => $field['name']
                    ],
                    [
                        'field_value' => $request->{$field['name']}
                    ]
                );
            }
        }


        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'required|array', // Array of role IDs
            'roles.*' => 'exists:roles,id', // Ensure each role ID exists in roles table
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        
        // Save the phone number
        if ($request->filled('phone')) {
            $user->phone = preg_replace('/\D/', '', $request->phone);
        }
        
        $user->save();
        
        // assign roles
        $user->roles()->sync($validatedData['roles']);
        

        // save custom fields
        $fields = UserCustomField::fields();
        if (!empty($fields)) {
            foreach ($fields as $field) {
                UserCustomField::updateOrCreate(
                    [
                        'user_id' => $request->id,
                        'field_key' => $field['name']
                    ],
                    [
                        'field_value' => $request->{$field['name']}
                    ]
                );
            }
        }

        return back()->with('success', 'User updated successfully.');
    }

    
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
