<?php
namespace App\Storage\Eloquent;


use App\Models\TagsModel;
use App\Storage\TagStorageInterface;

class TagsEloquentStorage implements TagStorageInterface
{
    private $model = null;

    public function __construct() {
        $this->model = new TagsModel();
    }

    public function findAll()
    {
        return $this->model::all();
    }

    public function find($id)
    {
        return $this->model::where('task_id', $id)->get();
    }

    public function create(array $aPost)
    {
        return $this->model::create($aPost);
    }

    public function remove($oObject)
    {
        return $oObject->delete();
    }

    public function save($oObject, array $aData)
    {
        foreach ($oObject as $key => $value) {
            $oObject->$key = $value;
        }
        return $oObject->save();
    }
}
