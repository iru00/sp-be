<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Http\Models\Post;
use Illuminate\Support\Facades\Validator;

class AdminUController extends Controller
{
    public function getAllPost(){
        $items = DB::table('posts')->get();
        return response()->json(['items' => $items]);
    }

    public function createPost(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'img_path' => 'required',
            'img_banner' => 'required',
            'text' => 'required',
            'days' => 'required',
            'locate' => 'required',
            'link_locate' => 'required',
            'category_id' => 'required',
            'user_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
    
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 422);
        }
    
        $post = Post::create([
            'title'          => $request->input('title'),
            'img_path'         => $request->input('img_path'),
            'img_banner'     => $request->input('img_banner'),
            'text' => $request->input('text'),
            'days'        => $request->input('days'),
            'locate'      => bcrypt($request->input('locate')),
            'link_locate'          => $request->input('link_locate'),
            'category_id'          => $request->input('category_id'),
            'user_id'          => $request->input('user_id'),
            'start_date'          => $request->input('start_date'),
            'end_date'          => $request->input('end_date'),
        ]);
    
        return response()->json($post, 201);
    }
}
