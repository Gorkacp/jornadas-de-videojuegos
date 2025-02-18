<?php

namespace App\Repositories;

use App\Models\Speaker;

interface SpeakerRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update(Speaker $speaker, array $data);
    public function delete(Speaker $speaker);
}