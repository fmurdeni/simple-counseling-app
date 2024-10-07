<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use App\Models\UserCustomField;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // Save the phone number
        if ($request->filled('phone')) {
            $request->user()->phone = preg_replace('/\D/', '', $request->phone);
        }

        // Save the role
        if ($request->filled('role')) {
            $request->user()->role = $request->role;
        }

        $request->user()->save();

        // save custom fields
        $fields = UserCustomField::fields();
        if (!empty($fields)) {
            foreach ($fields as $field) {
                UserCustomField::updateOrCreate(
                    [
                        'user_id' => $request->user()->id,
                        'field_key' => $field['name']
                    ],
                    [
                        'field_value' => $request->{$field['name']}
                    ]
                );
            }
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::route('dashboard')->with('status', 'user-deleted');
    }
}
