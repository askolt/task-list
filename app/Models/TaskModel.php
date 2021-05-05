<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskModel extends Model
{
    use HasFactory;

    protected $table = 'tasks';
    protected $primaryKey = 'id';
    public $timestamps = true;

    public $fillable = ['uuid', 'name', 'description', 'owner_id', 'priority', 'status'];


    public function getOwnerId()
    {
        return $this->owner_id;
    }
}
