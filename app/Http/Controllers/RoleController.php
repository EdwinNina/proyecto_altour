<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar == ""){
            $roles = Role::orderBy('roles.id','desc')->paginate(5);
        }else{
            $roles = Role::where($criterio,'like','%'.$buscar.'%')
                    ->orderBy('roles.id','desc')->paginate(5);
        }
        return [
            'roles' => $roles,
            'pagination' => [
                'total' => $roles->total(),
                'current_page' => $roles->currentPage(),
                'per_page' => $roles->perPage(),
                'last_page' => $roles->lastPage(),
                'from' => $roles->firstItem(),
                'to' => $roles->lastItem(),
            ]
        ];
    }
    public function store(RoleRequest $request)
    {
        if(!$request->ajax()) return redirect('/');

        Role::create($request->all());            
    }


    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        Role::findOrFail($request->id)->update($request->all());
    }

    public function destroy(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        Role::findOrFail($request->id)->delete();
    }
    public function selectRoles()
    {
        $roles = Role::select('id','name')->get();

        return $roles;
    }
}
