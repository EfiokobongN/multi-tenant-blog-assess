<?php

namespace App\utility;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class Util {
    public static function Auth(){
        $user = Auth::guard('sanctum')->user();

        return $user;
    }

    public static function storeImage($request){
        $imagePath = [];
        $fileImage = $request->file('images');
        $originalName = $fileImage->getClientOriginalName();
        $imagePath = $fileImage->storeAs('posts', $originalName, 'public');

        return  $imagePath;
    }
}