<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Employe;
use App\Models\Projects;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class ProjectController extends Controller
{
    public function getData()
    {
        $projects = Projects::query()->with(['tasks','tasks.subtasks'])->get();

        $progress = [];
        $percentGlobal = 0;
        foreach ($projects as $project) {
            $percent = 0;
            foreach ($project->tasks as $task) {
               $percent = $percent + round($task->subtasks->average('presentase_progress'));
            }
            array_push($progress, ($percent / (count($project->tasks) > 0 ? count($project->tasks) : 1)));
        }


        $project = $projects->map(function ($item) {
            return [
                $item->nama_proyek
            ];
        });

        $res = [
            'project' => $project,
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
        $role = auth()->user()->role;



        $pegawai = Employe::query()->get();
        $data = Projects::query()
//            ->when($role, function ($q) use ($role) {
//                if ($role === 'pegawai') {
//                    return $q->where('id_pegawai', auth()->user()->pegawai->id_pegawai);
//                }
//            })
            ->get()->map(function ($item) {
            $date1 = date_create($item->tanggal_plan_awal_proyek);
            $date2 = date_create($item->tanggal_plan_akhir_proyek);
            $duration = date_diff($date1, $date2)->days;
            return [
                'nama_proyek'         => $item->nama_proyek,
                'duration'            => $duration,
                'status' => $item->status,
                'id_proyek' => $item->id_proyek
            ];
        });
        return view('project.index', compact('data','pegawai'));
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
            $projects = new Projects();
            $projects->nama_proyek                  = $input['name'];
            $projects->id_pegawai                   = implode(", ",$input['id_employe']) ;
            $projects->tanggal_plan_awal_proyek     = $input['start_date_plan'];
            $projects->tanggal_plan_akhir_proyek    = $input['end_date_plan'];
//            $projects->tanggal_aktual_awal_proyek   = date('Y-m-d');
//            $projects->tanggal_aktual_akhir_proyek  = date('Y-m-d');
            $projects->status                       = $input['status'];
            $projects->save();
            DB::commit();
            return response()->json([
                'code'    => '200',
                'status'  =>  true,
                'message' => 'berhasil membuat proyek',
                'data'    => $projects
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
    public function show(Request $request, $id)
    {

            $plus7days  = date('Y-m-d', strtotime('+7 days'));
            $today      = date('Y-m-d', strtotime('today'));
            $input      = $request->all();
            $startDate = (array_key_exists('start', $input)) ? date('Y-m-d', strtotime($input['start'])) : $today;
            $endDate = (array_key_exists('end', $input)) ? date('Y-m-d', strtotime($input['end'])) : $today;

            $filter     = array_key_exists('filter', $input) ? $input['filter'] : null;
            $pegawai    = Employe::query()->get();
            $task       = Task::query()
                ->where('id_proyek', $id)
                ->when($filter, function ($query) use ($filter, $startDate, $endDate) {
                    if ($filter === 'harian') {
                        return $query->where('tanggal_plan_awal', '>=' ,$startDate)->where('tanggal_plan_awal', '<=' ,$endDate);
                    }
                })->get()->map(function ($item) {
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
                        'id_pegawai' => $item->id_pegawai,
                        'status' => $item->status,
                        'id_task' => $item->id_task,
                        'id_proyek' => $item->id_proyek,
                        'label_task' => $item->label_task,
                        'deskripsi_task' => $item->deskripsi_task,
                        'tanggal_plan_awal' => $item->tanggal_plan_awal,
                        'tanggal_plan_akhir' => $item->tanggal_plan_akhir,
                        'tanggal_aktual_awal' => $item->tanggal_aktual_awal,
                        'tanggal_aktual_akhir' => $item->tanggal_aktual_akhir,
                        'presentase_progress' => round($item->subtasks->average('presentase_progress')),
                        'employee' => $arr
                    ];
                });
            $project       = Projects::query()->find($id);
            $activity   = Activity::query()
                ->whereHas('task', function ($q) use ($id) {
                    $q->where('id_proyek', $id);
                })
                ->when($filter, function ($query) use ($filter, $startDate, $endDate) {
                    if ($filter === 'harian') {
                        return $query->where('tanggal_plan_awal', '>=' ,$startDate)->where('tanggal_plan_awal', '<=' ,$endDate);
                    }
                })->get()->map(function ($item) {
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
                        'task'                  => $item->task->label_task,
                        'id_activity'           => $item->id_activity,
                        'id_task'               => $item->id_task,
                        'id_pegawai'            => $item->id_pegawai,
                        'label_activity'        => $item->label_activity,
                        'deskripsi_activity'    => $item->deskripsi_activity,
                        'tanggal_plan_awal'     => $item->tanggal_plan_awal,
                        'tanggal_plan_akhir'    => $item->tanggal_plan_akhir,
                        'tanggal_aktual_awal'   => $item->tanggal_aktual_awal,
                        'tanggal_aktual_akhir'  => $item->tanggal_aktual_akhir,
                        'presentase_progress'   => $item->presentase_progress,
                        'status'                => $item->status,
                        'employee'              => $arr
                    ];
                });

            $progress = [10,40,50];
        return view('task.index', compact('project','task','activity','pegawai','progress'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pegawai = Employe::query()->get();
        $data = Projects::query()->find($id);
        $html = view('project.inc.detail', compact('data','pegawai'))->renderSections();
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

        $projects = Projects::find($id);
        DB::beginTransaction();
        try {
            $projects->nama_proyek                  = $input['name'];
            $projects->id_pegawai                   = implode(", ",$input['id_employe']) ;
            $projects->tanggal_plan_awal_proyek     = $input['start_date_plan'];
            $projects->tanggal_plan_akhir_proyek    = $input['end_date_plan'];
            $projects->tanggal_aktual_awal_proyek   = $input['start_date_actual'];
            $projects->tanggal_aktual_akhir_proyek  = $input['end_date_actual'];
            $projects->status                       = $input['status'];
            $projects->save();
            DB::commit();
            return response()->json([
                'code'    => '200',
                'status'  => true,
                'message' => 'Berhasil mengubah proyek',
                'data'    => $projects
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
        $data = Projects::query()->find($id);
        DB::beginTransaction();
        try {
            $data->delete();
            DB::commit();
            return response()->json([
                'code'    => '200',
                'status'  =>  true,
                'message' => 'berhasil menghapus proyek',
                'data'    => $data
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
