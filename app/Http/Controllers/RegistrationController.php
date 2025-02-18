<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller{
    public function index()
    {
        $registrations = Registration::all();
        return view('registrations.index', compact('registrations'));
    }

    public function create()
    {
        return view('registrations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'event_id' => 'required|exists:events,id',
            'registration_type' => 'required|in:presencial,virtual,gratuita',
            'confirmed' => 'boolean',
        ]);

        Registration::create($request->all());

        return redirect()->route('registrations.index');
    }

    public function show(Registration $registration)
    {
        return view('registrations.show', compact('registration'));
    }

    public function edit(Registration $registration)
    {
        return view('registrations.edit', compact('registration'));
    }

    public function update(Request $request, Registration $registration)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'event_id' => 'required|exists:events,id',
            'registration_type' => 'required|in:presencial,virtual,gratuita',
            'confirmed' => 'boolean',
        ]);

        $registration->update($request->all());

        return redirect()->route('registrations.index');
    }

    public function destroy(Registration $registration)
    {
        $registration->delete();

        return redirect()->route('registrations.index');
    }
}