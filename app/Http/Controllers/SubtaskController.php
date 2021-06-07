<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Employe;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubtaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $input = $request->all();
        $data =  Task::query()->find($input['task']);
        $pegawai =  Employe::query()->get();

        if ($data) {
            $html = view('subtask.inc.create', compact('data','pegawai'))->renderSections();
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
            $task = new Activity();
            $task->id_task              = $input['id_task'];
            $task->id_pegawai           = implode(", ",$input['id_employe']) ;
            $task->label_activity       = $input['label_activity'];
            $task->deskripsi_activity   = $input['description_activity'];
            $task->tanggal_plan_awal    = $input['start_date_plan_activity'];
            $task->tanggal_plan_akhir   = $input['end_date_plan_activity'];
            $task->presentase_progress  = $input['progress_activity'];
            $task->save();
            DB::commit();
            return response()->json([
                'code'    => '200',
                'status'  =>  true,
                'message' => 'berhasil membuat subtask',
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
        $data =  Activity::query()->find($id);
        $pegawai =  Employe::query()->get();
        if ($data) {
            $html = view('subtask.inc.edit', compact('data','pegawai'))->renderSections();
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
        $task = Activity::find($id);


        DB::beginTransaction();
        try {
            $task->id_pegawai           = array_key_exists('id_employe', $input) ? implode(", ",$input['id_employe']) : $task->id_pegawai;
            $task->label_activity       = array_key_exists('label_activity', $input) ? $input['label_activity'] : $task->label_activity;
            $task->deskripsi_activity   = array_key_exists('description_activity', $input) ? $input['description_activity'] : $task->deskripsi_activity;
            $task->tanggal_plan_awal    = array_key_exists('start_date_plan_activity', $input) ? $input['start_date_plan_activity'] : $task->tanggal_plan_awal;
            $task->tanggal_plan_akhir   = array_key_exists('end_date_plan_activity', $input) ? $input['end_date_plan_activity'] : $task->tanggal_plan_akhir;



            if ($input['status_activity'] === 'in progress') {
//                $task->tanggal_aktual_awal  = array_key_exists('start_date_actual_activity', $input) ? $input['start_date_actual_activity'] : $task->tanggal_aktual_awal;
                $task->tanggal_aktual_awal  = date('Y-m-d H:i:s');
            }

            if ($input['status_activity'] === 'done') {
//                $task->tanggal_aktual_akhir = array_key_exists('end_date_actual_activity', $input) ? $input['end_date_actual_activity'] : $task->tanggal_aktual_akhir;
                $task->tanggal_aktual_akhir = date('Y-m-d H:i:s');
            }

            $task->presentase_progress  = $input['progress_activity'];
            $task->status               = $input['status_activity'];
            $task->save();
            DB::commit();
            return response()->json([
                'code'    => '200',
                'status'  => true,
                'message' => 'Berhasil mengubah subtask',
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
        $data = Activity::query()->find($id);
        DB::beginTransaction();
        try {
            $data->delete();
            DB::commit();
            return response()->json([
                'code'    => '200',
                'status'  =>  true,
                'message' => 'berhasil menghapus subtask',
                'data'    => $data
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
