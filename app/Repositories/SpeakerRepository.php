<?php

namespace App\Repositories;

use App\Models\Speaker;

class SpeakerRepository implements SpeakerRepositoryInterface
{
    public function all()
    {
        return Speaker::all();
    }

    public function find($id)
    {
        return Speaker::findOrFail($id);
    }

    public function create(array $data)
    {
        return Speaker::create($data);
    }

    public function update(Speaker $speaker, array $data)
    {
        return $speaker->update($data);
    }

    public function delete(Speaker $speaker)
    {
        return $speaker->delete();
    }
}