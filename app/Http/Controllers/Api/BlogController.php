<?php

namespace App\Http\Controllers\api;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    public function create(Request $request){
        /* $request->validate([
            'title'=>'required',
            'content'=>'required'
        ]); */

        $user_id=auth()->user()->id;
        $blog=new Blog();
        $blog->title=$request->title;
        $blog->content=$request->content;
        $blog->userId=$user_id;
        $blog->save();
        return response([
            "status" => 1,
            "msg" => "¡Blog creado exitosamente!"
        ]);
    }
    public function list(){
        $user_id=auth()->user()->id;
        $blogs = Blog::where("userId", $user_id)->get();
        return response()->json([
            "status"=>1,
            "msg"=>"blogs",
            "data"=>$blogs
        ]);
    }
    public function show($id){
        $user_id=auth()->user()->id;
        if(Blog::where(["id"=>$id,"userId"=>$user_id])->exists()){
            $info=Blog::where(["id"=>$id,"userId"=>$user_id])->get();
            return response()->json([
                "status"=>1,
                "msg"=>$info
            ],Response::HTTP_OK);
        }else{
            return response()->json([
                "status"=>0,
                "msg"=>"no se encontró el blog"
            ],404);
        }
    }
    public function update(Request $request,$id){
        $user_id=auth()->user()->id;
        if(Blog::where(["userId"=>$user_id,"id"=>$id])->exists()){
            $blog=Blog::find($id);
            $blog->title=isset($request->title)?$request->title:$blog->title;
            $blog->content=isset($request->content)?$request->content:$blog->content;
            $blog->save();
            return response()->json([
                "status"=>1,
                "msg"=>"blog actualizado"
            ],Response::HTTP_OK);
        }else{
            return response()->json([
                "status"=>0,
                "msg"=>"no se econtró el blog"
            ],404);
        }
    }
    public function delete($id){
        $user_id=auth()->user()->id;
        if(Blog::where(["userId"=>$user_id,"id"=>$id])->exists()){
            $blog = Blog::where( ["id" => $id, "userId" => $user_id ])->first();
            $blog->delete();
            return response()->json([
                "status"=>1,
                "msg"=>"blog eliminado"
            ],Response::HTTP_OK);
        }else{
            return response()->json([
                "status"=>0,
                "msg"=>"no se econtró el blog"
            ],404);
        }
    }
}
