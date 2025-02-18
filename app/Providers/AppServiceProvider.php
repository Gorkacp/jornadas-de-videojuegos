<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\EventRepositoryInterface;
use App\Repositories\EventRepository;
use App\Repositories\SpeakerRepositoryInterface;
use App\Repositories\SpeakerRepository;
use App\Repositories\AssistantRepositoryInterface;
use App\Repositories\AssistantRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(EventRepositoryInterface::class, EventRepository::class);
        $this->app->bind(SpeakerRepositoryInterface::class, SpeakerRepository::class);
        $this->app->bind(AssistantRepositoryInterface::class, AssistantRepository::class);
    }

    public function boot()
    {
        //
    }
}