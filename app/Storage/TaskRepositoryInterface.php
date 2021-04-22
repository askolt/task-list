<?php
namespace App\Storage;

interface TaskRepositoryInterface
{
    public function findAll();
    public function findById($id);
//    public function getByUserId();
    public function save(array $aData);
//    public function getTagsById($iId);
//    public function setTagsById($iId, array $aData);
    public function removeTask($uuid);
}
