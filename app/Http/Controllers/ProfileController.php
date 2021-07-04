<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($user)
    {
        $posts = $this->getPosts(Crypt::encrypt($user));
        $photo = User::where('name',$user)->get()[0]->photo;
        $banner = User::where('name',$user)->get()[0]->banner;
        $data = ['posts' => $posts->posts, 'user' => $user, 'photo' => $photo, 'banner' => $banner];
        return view('users.index', ['posts' => $data]);
    }

    public function getPosts($user)
    {
        $api = new Api;
        $user = Crypt::decrypt($user);
        if(User::where('name',$user)->get()->count() == 1){
            $post = $api->get($user);
        }else{
            abort(404, 'Page not found');
        }
        return $post;
    }

    public function upload(Request $file){
        $id = User::where('name',Auth::user()->name)->get()[0]->id;
        $user = User::find($id);
        $update = [];
        if($_FILES["file"]["size"] > 10000000){
            return response()->json(['msg' => 'La imagen supera los 1 MBs'],500);

        }
        if($_FILES["file"]["type"] != "image/jpeg" && $_FILES["file"]["type"] != "image/jpg" && $_FILES["file"]["type"] != "image/png"){
            return response()->json(['msg' => 'El Archivo no es válido'],500);
        }
        if($file->banner == "true"){
            $update["banner"] = $_FILES["file"]["name"];
        }else{
            $update["photo"] = $_FILES["file"]["name"];
        }
        if($file->hasFile('file')){
            $file->file('file')->move(public_path('/img/faces'), $_FILES["file"]["name"]);
            $user->update($update);
        }
        return response()->json(['msg' => 'Imagen actualizada!', 'img' => $_FILES["file"]["name"] ],200);
    }

}
