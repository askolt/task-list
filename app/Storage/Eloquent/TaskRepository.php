<?php


namespace App\Storage\Eloquent;


use App\Models\TaskModel;
use App\Storage\TaskStorageInterface;
use App\Storage\TagStorageInterface;
use App\Storage\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;
use App\Task;

class TaskRepository implements TaskRepositoryInterface
{
    private $oStorageTask = null;
    private $oStorageTags = null;

    public function __construct(TaskStorageInterface $oStorageTask, TagStorageInterface $oStorageTags)
    {
        $this->oStorageTask = $oStorageTask;
        $this->oStorageTags = $oStorageTags;
    }
//
//    public function getAll()
//    {
//        return $this->oStorageTask->findAll(1);
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
//        $this->oStorageTask->create($aData);
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
        $oTask = $this->oStorageTask->find($uuid);
        if ($oTask) {
            return $this->oStorageTask->remove($oTask);
        }
        return false;
    }

    public function save($aData)
    {
        if (empty($aData['uuid'])) {
            $oTask = Task::draft(0, $aData['name'], $aData['description']);
        } else {
            $oTask = $this->oStorageTask->find($aData['uuid']);
        }

        if ($oTask) {
            $aTags = $this->oStorageTags->find($oTask->getUuid());
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
            return $this->oStorageTask->save($oTask, $oTask->toArray());
        }
        return false;
    }

    public function findAll()
    {
        return $this->oStorageTask->findAll();
    }

    public function findById($id)
    {
        // TODO: Implement findById() method.
    }
}
