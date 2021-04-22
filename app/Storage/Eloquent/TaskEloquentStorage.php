<?php
namespace App\Storage\Eloquent;


use App\Models\TaskModel;
use App\Storage\TaskStorageInterface;

class TaskEloquentStorage implements TaskStorageInterface
{
    private $model = null;

    public function __construct() {
        $this->model = new TaskModel();
    }

    public function findAll()
    {
        return $this->model::all();
    }

    public function find($uuid)
    {
        return $this->model::where('uuid', $uuid)->first();
    }

    public function create(array $oObject)
    {
        return $this->model::create($oObject);
    }

    public function remove($oObject)
    {
        return $oObject->delete();
    }

    public function save($oObject, array $aData)
    {
        foreach ($aData as $key => $value) {
            $oObject->$key = $value;
        }
        return $oObject->save();
    }
}
