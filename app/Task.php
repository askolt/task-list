<?php
namespace App;

use App\TaskStatus;
use phpDocumentor\Reflection\Types\Integer;

class Task
{
    private $iPostId;
    private $sName;
    private $sDescription;
    private $iStatus;
    private $iPriority;

    private function __construct(
        Integer $iPostId,
        string $sName,
        string $sDescription,
        Integer $iStatus,
        Integer $iPriority
    ) {
        $this->iPostId = $iPostId;
        $this->sName = $sName;
        $this->sDescription = $sDescription;
        $this->iStatus = $iStatus;
        $this->iPriority = $iPriority;
    }

    public static function draft($iPostId, $sName, $sDesctiption): Task
    {
        return new self($iPostId, $sName, $sDesctiption, TaskStatus::STATUS_DRAFT, TaskPriority::PRIORITY_MILD);
    }

    public function changeStatus(TaskStatus $iNewStatus)
    {

    }

    public function getStatus()
    {
        return '';
    }

}
