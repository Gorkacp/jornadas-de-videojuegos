<?php

namespace App\Repositories;

use App\Models\Assistant;

class AssistantRepository implements AssistantRepositoryInterface
{
    public function all()
    {
        return Assistant::all();
    }

    public function find($id)
    {
        return Assistant::findOrFail($id);
    }

    public function create(array $data)
    {
        return Assistant::create($data);
    }

    public function update(Assistant $assistant, array $data)
    {
        return $assistant->update($data);
    }

    public function delete(Assistant $assistant)
    {
        return $assistant->delete();
    }
}