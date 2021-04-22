<?php

namespace App\Providers;

use App\Http\Controllers\TaskController;
use App\Models\TagsModel;
use App\Models\TaskModel;
use App\Storage\Eloquent\EloquentStorage;
use App\Storage\Eloquent\TaskEloquentStorage;
use App\Storage\Eloquent\TaskRepository;
use App\Storage\StorageInterface;
use App\Storage\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
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
        $this->app->bind(StorageInterface::class, TaskEloquentStorage::class);

//        $this->app->bind(EloquentStorage::class, TaskRepository::class);
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
