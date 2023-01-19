<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Models\Role;

class RolesController extends Controller
{
    public function roles(Request $request)
    {        
        $roles = Role::get();
        return response()->json(['status'=>true,'data'=>$roles],200);
    }
}
