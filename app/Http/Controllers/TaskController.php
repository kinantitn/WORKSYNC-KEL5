<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use App\Models\Projects;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class TaskController extends Controller
{
    public function getDataByProject(Request $request)
    {
        $input = $request->all();

        $task = Task::query()
            ->where('id_proyek', $input['project'])
            ->get()->map(function ($item) {
                $arr = [];
                $cat = $item->id_pegawai;
                $pieces = explode(',', $cat);
                for ($j = 0; $j < sizeof($pieces); $j++) {
                    $category = Employe::find($pieces[$j]);
                    if ($category) {
                        array_push($arr, $category->nama_lengkap);
                    }
                }
                return [
                    'label_task' => $item->label_task,
                    'presentase_progress' => round($item->subtasks->average('presentase_progress')),
                ];
            });


        $taskName = [];
        $progress = [];
        foreach ($task as $item) {
            array_push($taskName, $item['label_task']);
            array_push($progress, $item['presentase_progress']);
        }

        $res = [
            'taskName' => $taskName,
            'progress' => $progress,
        ];

        return response()->json($res);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pegawai = Employe::query()->get();
        return view('task.index', compact('pegawai'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        DB::beginTransaction();
        try {
            $task = new Task();
            $task->id_proyek            = $input['id_project'];
            $task->id_pegawai           = implode(", ",$input['id_employe']) ;
            $task->label_task           = $input['label_task'];
            $task->deskripsi_task       = $input['description_task'];
            $task->tanggal_plan_awal    = $input['start_date_plan_task'];
            $task->tanggal_plan_akhir   = $input['end_date_plan_task'];
            $task->presentase_progress  = 0;
            $task->status               = 'new';
            $task->save();
            DB::commit();
            return response()->json([
                'code'    => '200',
                'status'  =>  true,
                'message' => 'berhasil membuat task',
                'data'    => $task
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'code'    => '500',
                'status'  => false,
                'message' => $e->getMessage(),
                'data'    => null
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data = Task::query()->where('id_task',$id)->first();
        $pegawai =  Employe::query()->get();
        if ($data) {
            $count = $data->subtasks->count('presentase_progress');
            $sum = $data->subtasks->sum('presentase_progress');
            $avg = 0;
            if ($sum) {
                $avg = $sum / $count;
            }
            $data->presentase_progress = round($avg);
            $html = view('task.inc.edit', compact('data','pegawai'))->renderSections();
            if (!$data) {
                $html = null;
            }

            return response()->json([
                'code'    => '200',
                'status'  =>  true,
                'message' => 'berhasil',
                'data'    => $html
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $task = Task::find($id);
        DB::beginTransaction();
        try {
            $task->label_task           = $input['label_task'];
            $task->id_pegawai           = implode(", ",$input['id_employe']) ;
            $task->deskripsi_task       = $input['description_task'];
            $task->tanggal_plan_awal    = $input['start_date_plan_task'];
            $task->tanggal_plan_akhir   = $input['end_date_plan_task'];
            $task->presentase_progress  = $input['progress_task'];
            $task->status               = $input['status'];
            if ($input['status'] === 'in progress') {
                $task->tanggal_aktual_awal  = date('Y-m-d H:i:s');
            }

            if ($input['status'] === 'done') {
                $task->tanggal_aktual_akhir = date('Y-m-d H:i:s');
            }
            $task->save();
            DB::commit();
            return response()->json([
                'code'    => '200',
                'status'  => true,
                'message' => 'Berhasil mengubah task',
                'data'    => $task
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'code'    => '500',
                'status'  => false,
                'message' => $e->getMessage(),
                'data'    => null
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Task::query()->find($id);
        DB::beginTransaction();
        try {
            $data->subtasks()->delete();
            $data->delete();
            DB::commit();
            return response()->json([
                'code'    => '200',
                'status'  =>  true,
                'message' => 'berhasil menghapus task dan subtask',
                'data'    => $data
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'code'    => '200',
                'status'  =>  true,
                'message' => $e->getMessage(),
                'data'    => null
            ]);
        }
    }
}
