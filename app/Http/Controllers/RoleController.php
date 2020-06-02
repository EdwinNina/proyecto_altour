<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function selectRoles()
    {
        $roles = Role::select('id','name')->get();

        return $roles;
    }
}
