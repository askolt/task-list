<?php

namespace App\Http\Controllers;

use App\Storage\TaskRepositoryInterface;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $oTaskRepository = null;

    public function __construct(TaskRepositoryInterface $oTaskRepository)
    {
        $this->middleware('auth');
        $this->oTaskRepository = $oTaskRepository;
    }

//    public function create(Request $request)
//    {
//        return $this->oTaskRepository->save([
//            'name' => 123,
//            'description' => 123,
//            'status' => 1,
//            'priority' => 1,
//        ]);
////        return $this->oTaskRepository->findById(1);
////        return $this->oTaskRepository->all();
//    }

    public function findAll()
    {
        return $this->oTaskRepository->findAll();
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:50',
            'description' => 'required',
            'status' => 'required|numeric',
            'priority' => 'required|numeric',
            'tags' => 'array',

        ]);
        $aData = $request->post();
        return $this->oTaskRepository->save($aData);
    }

    public function remove(Request $request, $uuid)
    {
        return $this->oTaskRepository->removeTask($uuid);
    }
}
