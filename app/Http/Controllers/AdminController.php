<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tenant;
use App\Models\User;
use App\utility\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function approvedUser(User $user){

        $auth = Util::Auth();
        if($auth->id === $user->id){
            return response()->json(['success' => true, 'message' => 'You can not approve yourself as a tenant.']);
        }
        DB::beginTransaction();
        try {

            if($user->is_approved){
                return response()->json(['success' => false, 'message' => 'User Account has already been approved.']);
            }

           //approved user account
        $user->is_approved = true;
        $user->role = User::$tenant;
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
    

    //GET ALL TENANTS POSTS IN THE DATABASE
    public function allpost(){
        $allPost = Post::with('tenant')->get();
        if ($allPost->isEmpty()) {
            return response()->json(['message' => 'No Post Found']);
        }

        return response()->json(['success' => true, 'message' => 'All Datas', 'allPost' => $allPost]);
    }

    //VIEW THE DETAILS OF A SINGLE POST

    public function viewPost(Post $post){
        $postId = $post;
        if (!$postId) {
            return response()->json([ 'message' => 'Post Not Found']);
        }

        return response()->json(['success' => true, 'message' => 'Post Details', 'postId' => $postId]);
    }
}
