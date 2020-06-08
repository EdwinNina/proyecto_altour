<?php

namespace App\Http\Controllers;

use App\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
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
        if(!$request->ajax()) return redirect('/');

        Like::where('user_id', Auth::user()->id)
        ->where('attractive_id',$request->id)
        ->create([
            'user_id' => Auth::user()->id,
            'attractive_id',$request->id
        ]);
    }

    public function show(Like $like)
    {
        //
    }

    public function disLike(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        Like::where('user_id', Auth::user()->id)
            ->where('attractive_id',$request->id)
            ->delete();
    }
}
