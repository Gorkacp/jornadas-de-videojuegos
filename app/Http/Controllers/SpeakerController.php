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
            'bio' => 'required|string',
            'photo' => 'nullable|image',
        ]);

        $this->speakerRepository->create($request->all());

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
            'bio' => 'required|string',
            'photo' => 'nullable|image',
        ]);

        $speaker = $this->speakerRepository->find($id);

        $this->speakerRepository->update($speaker, $request->all());

        return redirect()->route('speakers.index');
    }

    public function destroy($id)
    {
        $speaker = $this->speakerRepository->find($id);
        $this->speakerRepository->delete($speaker);

        return redirect()->route('speakers.index');
    }
}