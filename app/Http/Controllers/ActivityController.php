<?php

namespace App\Http\Controllers;

use App\Activity;
use Illuminate\Http\Request;
use App\Http\Requests\ActivityRequest;

class ActivityController extends Controller
{

    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if($buscar == ''){
            $activities = Activity::with('attractive')->orderBy('id','desc')->paginate(5);
        }else{
            $activities = Activity::with('attractive')->where($criterio,'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(5);
        }
        return [
            'activities' => $activities,
            'pagination' => [
                'total' => $activities->total(),
                'current_page' => $activities->currentPage(),
                'per_page' => $activities->perPage(),
                'last_page' => $activities->lastPage(),
                'from' => $activities->firstItem(),
                'to' => $activities->lastItem(),
            ]
        ];
    }

    public function store(ActivityRequest $request)
    {
        if(!$request->ajax()) return redirect('/');
        Activity::create($request->all());
    }

    public function detail(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $activity = Activity::join('attractives','attractives.id','=','activities.attractive_id')
                    ->select('activities.name','activities.description','activities.instructor',
                             'activities.cost','activities.date_start','activities.date_end',
                             'attractives.name as attractiveName','attractives.image')
                    ->where('activities.id',$request->id)
                    ->first();
        return $activity;
    }

    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        Activity::findOrFail($request->id)->update($request->all());
    }

    public function desactive(Request $request)
    {
        Activity::findOrFail($request->id)->update([
            'status' => 0
        ]);
    }
    public function active(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        Activity::findOrFail($request->id)->update([
            'status' => 1
        ]);
    }

    public function selectDates()
    {
        if(!$request->ajax()) return redirect('/');

        $activities = Activity::select('name as title','date_start as start','date_end as end')->where('status','1')->get();
        return $activities;
    }
}
