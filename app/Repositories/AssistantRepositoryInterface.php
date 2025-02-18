<?php

namespace App\Repositories;

use App\Models\Assistant;

interface AssistantRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update(Assistant $assistant, array $data);
    public function delete(Assistant $assistant);
}