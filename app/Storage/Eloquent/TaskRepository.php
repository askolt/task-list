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
        if ($bRes) {
            return ['status' => true, 'data' => $oTaskDraft->toArray()];
        }
        if ($oTaskStorage) {
            //@todo save tags
            $aTags = $this->oStorageTags->find($oTaskDraft->getUuid());
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
            if ($bRes) {
                return ['status' => true, 'data' => $oTaskDraft->toArray()];
            }
        }
        return ['status' => false];
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
