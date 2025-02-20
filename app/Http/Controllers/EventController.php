<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Speaker;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all(); // Obtiene todos los eventos de la base de datos
        return view('events.index', compact('events'));
    }

    public function create()
    {
        $speakers = Speaker::all();
        return view('events.create', compact('speakers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'max_attendees' => 'required|integer',
            'speaker_id' => 'required|exists:speakers,id',
        ]);

        $start_time = Carbon::parse($request->start_time);
        $end_time = Carbon::parse($request->end_time);

        // Validar que el evento sea jueves o viernes
        if (!in_array($start_time->dayOfWeek, [Carbon::THURSDAY, Carbon::FRIDAY])) {
            return redirect()->back()->withErrors(['start_time' => 'Los eventos solo pueden ser programados los días jueves y viernes.'])->withInput();
        }

        // Validar la duración del evento (55 minutos)
        if ($start_time->diffInMinutes($end_time) != 55) {
            return redirect()->back()->withErrors(['start_time' => 'La duración de los eventos debe ser de 55 minutos.'])->withInput();
        }

        // Validar que no se superpongan dos conferencias o dos talleres simultáneamente
        $conflictingEvents = Event::where('type', $request->type)
            ->where(function ($query) use ($start_time, $end_time) {
                $query->whereBetween('start_time', [$start_time, $end_time])
                      ->orWhereBetween('end_time', [$start_time, $end_time])
                      ->orWhere(function ($query) use ($start_time, $end_time) {
                          $query->where('start_time', '<=', $start_time)
                                ->where('end_time', '>=', $end_time);
                      });
            })
            ->exists();

        if ($conflictingEvents) {
            return redirect()->back()->withErrors(['start_time' => 'No pueden superponerse dos conferencias o dos talleres simultáneamente.'])->withInput();
        }

        Event::create(array_merge($request->all(), ['user_id' => Auth::id()]));

        return redirect()->route('events.index')->with('success', 'Evento creado exitosamente.');
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $speakers = Speaker::all();
        return view('events.edit', compact('event', 'speakers'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'max_attendees' => 'required|integer',
            'speaker_id' => 'required|exists:speakers,id',
        ]);

        $start_time = Carbon::parse($request->start_time);
        $end_time = Carbon::parse($request->end_time);

        // Validar que el evento sea jueves o viernes
        if (!in_array($start_time->dayOfWeek, [Carbon::THURSDAY, Carbon::FRIDAY])) {
            return redirect()->back()->withErrors(['start_time' => 'Los eventos solo pueden ser programados los días jueves y viernes.'])->withInput();
        }

        // Validar que no se superpongan dos conferencias o dos talleres simultáneamente
        $conflictingEvents = Event::where('type', $request->type)
            ->where('id', '!=', $event->id)
            ->where(function ($query) use ($start_time, $end_time) {
                $query->whereBetween('start_time', [$start_time, $end_time])
                      ->orWhereBetween('end_time', [$start_time, $end_time])
                      ->orWhere(function ($query) use ($start_time, $end_time) {
                          $query->where('start_time', '<=', $start_time)
                                ->where('end_time', '>=', $end_time);
                      });
            })
            ->exists();

        if ($conflictingEvents) {
            return redirect()->back()->withErrors(['start_time' => 'No pueden superponerse dos conferencias o dos talleres simultáneamente.'])->withInput();
        }

        $event->update($request->all());

        return redirect()->route('events.index')->with('success', 'Evento actualizado exitosamente.');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Evento eliminado exitosamente.');
    }
    public function earnings()
    {
        $events = Event::all();
        $earnings = 0;

        foreach ($events as $event) {
            if ($event->type == 'Presencial') {
                $earnings += $event->registrations->count() * 5;
            } elseif ($event->type == 'Virtual') {
                $earnings += $event->registrations->count() * 9;
            }
        }

        return view('events.earnings', compact('earnings'));
    }
}