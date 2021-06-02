<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        return Post::all();
    }

    public function store(Request $request){
        try{
            $post = new Post();
            $post->title = $request->title;
            $post->content = $request->content;
            $post->category_id = $request->category_id;

            if ($post->save()){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Post created successfully'
                ]);
            }
        }catch (\Exception $exception){
            return response()->json([
                'status'=> 'error',
                'message'=> $exception->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id){
        try{
            $post = Post::findOrFail($id);
            $post->title = $request->title;
            $post->content = $request->content;
            $post->category_id = $request->category_id;

            if ($post->save()){
                return response()->json([
                    'status'=> 'success',
                    'message' => 'Post updated successfully'
                ]);
            }
        }catch (\Exception $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function destroy(Request $request, $id){

        try{
            $post = Post::findOrFail($id);

            if ($post->delete()){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Post has been successfully deleted'
                ]);
            }
        }catch (\Exception $exception){
            return response()->json([
                'status' => 'success',
                'message' => $exception->getMessage()
            ]);
        }
    }
}
