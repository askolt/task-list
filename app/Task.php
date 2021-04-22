<?php
namespace App;

use App\TaskStatus;
use http\Exception\InvalidArgumentException;
use phpDocumentor\Reflection\Types\Integer;
use Ramsey\Uuid\Uuid;
use function PHPUnit\Framework\throwException;

class Task
{
    private $iTaskId = 0;
    private $sUuid;
    private $sName;
    private $sDescription;
    private $iStatus;
    private $iPriority;
    private $iOwnerId = 1; //@todo set owner

    private function __construct(
        string $sUuid,
        string $sName,
        string $sDescription,
        int $iStatus,
        int $iPriority
    ) {
        $this->sUuid = $sUuid;
        $this->sName = strip_tags($sName);
        $this->sDescription = strip_tags($sDescription);
        if (!$this->setStatus($iStatus)) {
            throwException(new InvalidArgumentException('Invalid status id'));
        }
        if (!$this->setPriority($iPriority)) {
            throwException(new InvalidArgumentException('Invalid priority id'));
        }
    }

    public static function draft(array $aData): Task
    {
        if (empty($aData['uuid'])) {
            $sUuid = Uuid::uuid4();
        } else {
            $sUuid = $aData['uuid'];
        }

        return new self($sUuid, $aData['name'], $aData['description'], $aData['status'], $aData['priority']);
    }

    private function setStatus($iStatus): bool
    {
        $iStatus = (int)$iStatus;
        if (
            $iStatus === TaskStatus::STATUS_DRAFT
            || $iStatus === TaskStatus::STATUS_AT_WORK
            || $iStatus === TaskStatus::STATUS_DONE
        ) {
            $this->iStatus = $iStatus;
            return true;
        }
        return false;
    }

    private function setPriority($iPriority): bool
    {
        $iPriority = (int)$iPriority;
        if (
            $iPriority === TaskPriority::PRIORITY_MILD
            || $iPriority === TaskPriority::PRIORITY_MODERATE
            || $iPriority === TaskPriority::PRIORITY_CRUCIAL
        ) {
            $this->iPriority = $iPriority;
            return true;
        }
        return false;
    }

    public function getStatus()
    {
        return $this->iStatus;
    }

    public function setOwnerId($iUserId)
    {
        $this->iOwnerId = $iUserId;
    }

    public function getUuid()
    {
        return $this->sUuid;
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->sUuid,
            'name' => $this->sName,
            'description' => $this->sDescription,
            'owner_id' => $this->iOwnerId,
            'priority' => $this->iPriority,
            'status' => $this->iStatus
        ];
    }

}
