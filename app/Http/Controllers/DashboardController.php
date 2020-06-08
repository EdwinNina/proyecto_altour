<?php

namespace App\Http\Controllers;

use App\Like;
use App\User;
use App\Activity;
use App\Category;
use App\Attractive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $attractives = Attractive::count();
        $activities =  Activity::count();
        $categories = Category::count();
        $tourists = User::where('role_id','=','3')->count();

        return [
            'attractives' => $attractives,
            'activities' => $activities,
            'categories' => $categories,
            'tourists' => $tourists
        ];
    }

    public function getLikes(Request $request){

        if(!$request->ajax()) return redirect('/');

        $likes = Like::join('users','users.id','likes.user_id')
                    ->join('places','places.id','likes.place_id')
                ->select('places.name',DB::raw("count(likes.user_id) as mount"))
                ->groupBy('likes.place_id')
                ->get();
        return $likes;
    }

}
