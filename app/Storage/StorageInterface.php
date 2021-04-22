<?php
namespace App\Storage;

interface StorageInterface
{
    public function findAll();
    public function find($iId);
//    public function findByUserId($iUserId);
//    public function findByUuid($sUuid);
    public function create(array $aData);
    public function save($oObject, array $aData);
    public function remove($oObject);
}
