<?php


namespace App\Storage\Eloquent;


use App\Models\TaskModel;
use App\Storage\StorageInterface;
use App\Storage\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class TaskRepository implements TaskRepositoryInterface
{
    private $oStorage = null;

    public function __construct(StorageInterface $oStorage)
    {
        $this->oStorage = $oStorage;
    }
//
//    public function getAll()
//    {
//        return $this->oStorage->findAll(1);
//    }
//
//    public function getByUserId()
//    {
//        // TODO: Implement getByUserId() method.
//    }

//    public function createTask(array $aData)
//    {
//        $aData['uuid'] = Uuid::uuid4()->toString();
//        $aData['owner_id'] = 1;
//        $this->oStorage->create($aData);
//    }
//
//    public function getTagsById($iId)
//    {
//        // TODO: Implement getTagsById() method.
//    }
//
//    public function setTagsById($iId, array $aData)
//    {
//        // TODO: Implement setTagsById() method.
//    }

    public function removeTask($uuid)
    {
        $oTask = $this->oStorage->find($uuid);
        if ($oTask) {
            return $this->oStorage->remove($oTask);
        }
        return false;
    }

    public function save($aData)
    {
        if (empty($aData['uuid'])) {
            $aData['uuid'] = Uuid::uuid4()->toString();
            $aData['owner_id'] = 1;
            $oTask = $this->oStorage->create($aData);
        } else {
            $oTask = $this->oStorage->find($aData['uuid']);
        }

        if ($oTask) {
            $oTagsModel = new TagsEloquentStorage();
            $aTags = $oTagsModel->findAll($oTask->id);
//            $aToPushTags = array_diff($aData['tags'], $aTags->values()->toArray());
//            $aToRemoveTags = array_diff($aTags->values()->toArray(), $aData['tags']);
//            foreach ($aToPushTags as $item) {
//                $oTagsModel->create([
//                    'name' => $item,
//                    'task_id' => $oTask->id
//                ]);
//            }
//            var_dump($aToPushTags, $aToRemoveTags);
//
//            exit;
//            unset($aData['tags']);
            return $this->oStorage->save($oTask, $aData);
        }
        return false;
    }

    public function findAll()
    {
        return $this->oStorage->findAll();
    }

    public function findById($id)
    {
        // TODO: Implement findById() method.
    }
}
