<?php

namespace App\Providers;

use App\Storage\Eloquent\EloquentStorage;
use App\Storage\Eloquent\TagEloquentStorage;
use App\Storage\Eloquent\TagsEloquentStorage;
use App\Storage\Eloquent\TaskEloquentStorage;
use App\Storage\Eloquent\TaskRepository;
use App\Storage\TaskStorageInterface;
use App\Storage\TagStorageInterface;
use App\Storage\TaskRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
        $this->app->bind(TagStorageInterface::class, TagsEloquentStorage::class);
        $this->app->bind(TaskStorageInterface::class, TaskEloquentStorage::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
