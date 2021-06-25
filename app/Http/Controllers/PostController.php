<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Post;
use App\Http\Requests\Validaciones;
use App\Http\Requests\ValidacionesUpdate;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class PostController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request)
    {
        $content = $request->content;
        $created_at = new DateTime();
        $validations = new Validaciones();
        $updated_at = $created_at;


        $validator = Validator::make($request->all(), $validations->rules(), $validations->messages());
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $post = new Post();
        $post->content = $content;
        $post->author = Auth::user()->name;
        $post->created_at = $created_at;
        $post->updated_at = $updated_at;
        $post->save();
        sleep(1);
        return redirect()->back();
        
    }

    public function update( Request $request)
    {
        $validations = new ValidacionesUpdate();
        $idPost = Crypt::decrypt($request->id);
        $content = "contentEdit".$idPost;
        $content = $request->$content;
        $created_at = new DateTime();
        $updated_at = $created_at;
        $validator = Validator::make($request->all(), $validations->rules($idPost), $validations->messages());

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $post = Post::find($idPost);
        if($post->author == Auth::user()->name){
            $post->content = $content;
            $post->created_at = $created_at;
            $post->updated_at = $updated_at;
            $post->save();
        }else{
            return redirect()->back()->withErrors("Error desconocido");
        }
        sleep(1);
        return redirect()->back();
    }

    public function delete( Request $request)
    {
        $idPost = Crypt::decrypt($request->idPost);
        $post = Post::find($idPost);
        if($post->author == Auth::user()->name){
            $post->delete();
        }else{
            return redirect()->back()->withErrors("Error desconocido");
        }
        sleep(1);
        return redirect()->back();

    }
}
