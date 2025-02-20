<?php

namespace App\Http\Controllers;

use App\Repositories\SpeakerRepositoryInterface;
use Illuminate\Http\Request;

class SpeakerController extends Controller
{
    protected $speakerRepository;

    public function __construct(SpeakerRepositoryInterface $speakerRepository)
    {
        $this->speakerRepository = $speakerRepository;
    }

    public function index()
    {
        $speakers = $this->speakerRepository->all();
    
        // Decodificar social_links JSON
        foreach ($speakers as $speaker) {
            $speaker->social_links = json_decode($speaker->social_links, true);
        }
    
        return view('speakers.index', compact('speakers'));
    }
    

    public function create()
    {
        return view('speakers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image',
            'expertise' => 'required|string|max:255',
            'social_links' => 'nullable|array',
            'social_links.*' => 'nullable|url',
        ]);

        $data = $request->all();
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        // Convertir social_links a JSON
        if (isset($data['social_links'])) {
            $data['social_links'] = json_encode($data['social_links']);
        }

        $this->speakerRepository->create($data);

        return redirect()->route('speakers.index');
    }

    public function show($id)
    {
        $speaker = $this->speakerRepository->find($id);
        return view('speakers.show', compact('speaker'));
    }

    public function edit($id)
    {
        $speaker = $this->speakerRepository->find($id);
        return view('speakers.edit', compact('speaker'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image',
            'expertise' => 'required|string|max:255',
            'social_links' => 'nullable|array',
            'social_links.*' => 'nullable|url',
        ]);
    
        $speaker = $this->speakerRepository->find($id);
    
        // Obtenemos todos los datos del formulario
        $data = $request->all();
    
        // Si hay una nueva foto, la guardamos
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }
    
        // Convertir social_links a JSON si existen
        if (isset($data['social_links']) && is_array($data['social_links'])) {
            // Asegurarnos de que el array esté limpio (sin valores nulos)
            $data['social_links'] = json_encode(array_filter($data['social_links'], function($value) {
                return !is_null($value) && $value !== '';
            }));
        }
    
        // Actualizamos el ponente con los datos modificados
        $this->speakerRepository->update($speaker, $data);
    
        return redirect()->route('speakers.index');
    }
    

    public function destroy($id)
    {
        $speaker = $this->speakerRepository->find($id);
        $this->speakerRepository->delete($speaker);

        return redirect()->route('speakers.index');
    }
}