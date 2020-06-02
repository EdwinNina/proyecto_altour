<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar == ""){
            $users = User::join('roles','roles.id','=','users.role_id')
                    ->select('users.id','users.name','users.email','users.status','users.role_id','roles.name as role')
                    ->orderBy('users.id','desc')->paginate(5);
        }else{
            $users = User::join('roles','roles.id','=','users.role_id')
                    ->select('users.id','users.name','users.email','users.status','users.role_id','roles.name as role')
                    ->where($criterio,'like','%'.$buscar.'%')
                    ->orderBy('users.id','desc')->paginate(5);
        }
        return [
            'users' => $users,
            'pagination' => [
                'total' => $users->total(),
                'current_page' => $users->currentPage(),
                'per_page' => $users->perPage(),
                'last_page' => $users->lastPage(),
                'from' => $users->firstItem(),
                'to' => $users->lastItem(),
            ]
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        if($request->ajax()){
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role_id' => $request->role_id
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
    public function update(Request $request)
    {
        if($request->ajax()){
            User::findOrFail($request->id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role_id' => $request->role_id
            ]);
        }
    }

    public function destroy(Request $request)
    {
        User::findOrFail($request->id)->delete();
    }
}
