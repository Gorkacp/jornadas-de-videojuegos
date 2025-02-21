<?php

namespace App\Http\Controllers;

use App\Models\Assistant;
use App\Models\Event;
use App\Models\User;
use App\Notifications\EventRegistrationNotification;
use App\Notifications\PaymentReceipt;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssistantController extends Controller
{
    public function index()
    {
        $assistants = Assistant::where('user_id', Auth::id())->get();
        return view('assistants.index', compact('assistants'));
    }

    public function create()
    {
        $events = Event::all();
        return view('assistants.create', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'event_id' => 'required|exists:events,id',
            'attendance_type' => 'required|in:presencial,virtual,gratuita',
        ]);

        // Verificar si el correo electrónico está registrado en la base de datos de usuarios
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'Este correo electrónico no está registrado en la base de datos.'])->withInput();
        }

        // Validación personalizada para correos electrónicos de estudiantes
        if ($request->attendance_type === 'gratuita' && !str_ends_with($request->email, '@iesalpujarra.org')) {
            return redirect()->back()->withErrors(['email' => 'No cumples los requisitos de estudiante.'])->withInput();
        }

        $event = Event::find($request->event_id);

        // Verificar si el evento está lleno
        if ($event->isFull()) {
            return redirect()->back()->withErrors(['event_id' => 'El evento está lleno.'])->withInput();
        }

        // Verificar si el usuario ya está registrado en el evento
        $existingAssistant = Assistant::where('email', $request->email)
            ->where('event_id', $request->event_id)
            ->first();

        if ($existingAssistant) {
            return redirect()->back()->withErrors(['email' => 'Ya estás registrado en este evento.'])->withInput();
        }

        // Verificar el número de conferencias y talleres registrados
        $conferenceCount = Assistant::where('user_id', $user->id)
            ->whereHas('event', function ($query) {
                $query->where('type', 'conference');
            })
            ->count();

        $workshopCount = Assistant::where('user_id', $user->id)
            ->whereHas('event', function ($query) {
                $query->where('type', 'workshop');
            })
            ->count();

        if ($event->type == 'conference' && $conferenceCount >= 5) {
            return redirect()->back()->withErrors(['event_id' => 'No puedes registrarte en más de 5 conferencias.'])->withInput();
        }

        if ($event->type == 'workshop' && $workshopCount >= 4) {
            return redirect()->back()->withErrors(['event_id' => 'No puedes registrarte en más de 4 talleres.'])->withInput();
        }

        $assistant = Assistant::create([
            'user_id' => $user->id,
            'event_id' => $request->event_id,
            'name' => $request->name,
            'email' => $request->email,
            'attendance_type' => $request->attendance_type,
        ]);

        // Enviar notificación de confirmación de registro
        $assistant->notify(new EventRegistrationNotification($assistant));

        // Redirigir a la página de pago si no es gratuita
        if ($request->attendance_type !== 'gratuita') {
            return redirect()->route('assistants.payment', $assistant->id);
        }

        return redirect()->route('assistants.index')->with('success', 'Registrado exitosamente.');
    }

    public function show($id)
    {
        $assistant = Assistant::find($id);
        return view('assistants.show', compact('assistant'));
    }

    public function edit($id)
    {
        $assistant = Assistant::find($id);
        $events = Event::all();
        return view('assistants.edit', compact('assistant', 'events'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:assistants,email,' . $id,
            'event_id' => 'required|exists:events,id',
            'attendance_type' => 'required|in:presencial,virtual,gratuita',
        ]);

        $assistant = Assistant::find($id);
        $assistant->update($request->all());

        return redirect()->route('assistants.index')->with('success', 'Actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $assistant = Assistant::find($id);
        $assistant->delete();

        return redirect()->route('assistants.index')->with('success', 'Eliminado exitosamente.');
    }

    public function payment($id)
    {
        $assistant = Assistant::find($id);
        return view('assistants.payment', compact('assistant'));
    }

    public function completePayment(Request $request, $id)
    {
        $assistant = Assistant::find($id);

        if (!$assistant) {
            return redirect()->route('assistants.index')->withErrors(['error' => 'Asistente no encontrado.']);
        }

        $assistant->payment_status = 'completed';
        $assistant->save();

        // Enviar notificación de comprobante de pago
        $assistant->notify(new PaymentReceipt($assistant));

        return redirect()->route('assistants.index')->with('success', 'Pago completado exitosamente.');
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'assistant_id' => 'required|exists:assistants,id',
            'total' => 'required|numeric|min:0.01',
        ]);

        $assistant = Assistant::find($request->assistant_id);

        // Registrar el pago en la base de datos
        Payment::create([
            'user_id' => $assistant->user_id,
            'amount' => $request->total,
            'payment_method' => 'Simulated',
            'payment_status' => 'Completed',
        ]);

        // Enviar notificación de comprobante de pago
        $assistant->notify(new PaymentReceipt($assistant));

        return redirect()->route('events.index')->with('success', 'Pago realizado exitosamente.');
    }
}