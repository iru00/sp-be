<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Http\Models\Post;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function getListbyCategory(Request $request){
        $category = $request->input('category_name');
        $limit = $request->input('limit', 10);

        $items = DB::table('posts')
        ->join('categories', 'posts.category_id', '=', 'categories.id')
        ->select('posts.*')
        ->where('categories.name', $category)
        ->orderBy('posts.id', 'desc')
        ->take($limit)
        ->get();

        return response()->json(['items' => $items]);
    }

    public function getListLinkCategory(Request $request){
        $post = $request->input('post_name');
        $category = $request->input('category_name');
        $limit = $request->input('limit', 10);

        $items = DB::table('links')
        ->join('posts', 'links.post_id', '=', 'posts.id')
        ->join('categories', 'links.category_id', '=', 'categories.id')
        ->select('links.*')
        ->where('posts.title', $post)
        ->where('categories.name', $category)
        ->orderBy('links.id', 'desc')
        ->take($limit)
        ->get();

        return response()->json(['items' => $items]);
    }

    public function getListDescCategory(Request $request){
        $currentDate = now()->toDateString();
        $category = $request->input('category_name');
        $limit = $request->input('limit', 10);

        $items = DB::table('posts')
        ->join('categories', 'posts.category_id', '=', 'categories.id')
        ->select('posts.*')
        ->where('categories.name', $category)
        ->where('end_date', '>' , $currentDate)
        ->orderBy('posts.id', 'desc')
        ->take($limit)
        ->get();

        return response()->json(['items' => $items]);
    }

    public function getDetailPost($id){
        $post = DB::table('posts')
        ->where('hash_id', $id)
        ->first();

        return response()->json(['item' => $post]);
    }
    
}