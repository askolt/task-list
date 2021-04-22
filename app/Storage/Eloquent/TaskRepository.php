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
            $aTags = $this->oStorageTags->find($uuid);
            foreach ($aTags as $aTag) {
                $this->oStorageTags->remove($aTag);
            }
            return $this->oStorageTask->remove($oTask);
        }
        return false;
    }

    public function save($aData)
    {
        try {
            $oTaskDraft = Task::draft($aData);
        } catch (\Exception $exception) {
            return [
                'status' => 'false',
                'message' => $exception->getMessage()
            ];
        }
            //@todo allow fields to fill
        $oTaskStorage = $this->oStorageTask->find($oTaskDraft->getUuid());
        //for new tasks
        if (!$oTaskStorage) {
            $bRes = $this->oStorageTask->create($oTaskDraft->toArray());
            if ($bRes) {
                $oTaskStorage = $this->oStorageTask->find($oTaskDraft->getUuid());
            } else {
                //@todo make better
                return [
                    'status' => 'false',
                    'message' => 'Task not saved'
                ];
            }
        } else {
            $bRes =  $this->oStorageTask->save($oTaskStorage, $oTaskDraft->toArray());
        }
        if ($oTaskStorage) {
            if (empty($aData['tags'])) {
                $aTagsToPush = [];
            } else {
                $aTagsToPush = $aData['tags'];
                $aTagsToPush = array_unique($aTagsToPush);
                $aTagsToPush = array_filter($aTagsToPush, function($value) {
                    return !is_null($value) && $value !== '';
                });
                foreach ($aTagsToPush as &$aTag) {
                    $aTag = htmlentities($aTag);
                    //@todo check
                    $aTag = mb_substr($aTag, 0, 49);
                }
                unset($aTag);
            }
            $aTags = $this->oStorageTags->find($oTaskDraft->getUuid());
            foreach ($aTags as $aTag) {
                $this->oStorageTags->remove($aTag);
            }
            foreach ($aTagsToPush as $item) {
                $this->oStorageTags->create([
                    'name' => $item,
                    'task_id' => $oTaskDraft->getUuid()
                ]);
            }
        }
        if ($bRes) {
            return ['status' => true, 'data' => $oTaskDraft->toArray()];
        }
        return ['status' => false];
    }

    public function findAll()
    {
        $aTasks = $this->oStorageTask->findAll();
        foreach ($aTasks as $oTask) {
            $oTask->tags = $this->oStorageTags->find($oTask->uuid)->pluck('name')->toArray();
        }
        return $aTasks;
    }

    public function findById($id)
    {
        // TODO: Implement findById() method.
    }
}
