<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function approvedUser(User $user){

        DB::beginTransaction();
        try {
           //approved user account
        $user->is_approved = true;
        $user->save();


        //Create A tenant
        $tenant = new Tenant();
        $tenant->tenant_name = $user->name;
        $tenant->user_id = $user->id;
        $tenant->save();


        //Update the tenant_id in the user Table
        $user->tenant_id = $tenant->id;
        $user->update();
        Db::commit();

        return response()->json(['success' => true, 'message' => 'User account approve and Tenant created']);
        } catch (\Throwable $th) {
           DB::rollBack();
           return response()->json(['message' => $th->getMessage()]);
        }
    }

    public function allpost(){
        $allPost = Post::all()->with('tenant')->get();
        if (!$allPost) {
            return response()->json([ 'message' => 'No Post Found']);
        }

        return response()->json(['success' => true, 'message' => 'All Datas', 'allPost' => $allPost]);
    }
}
