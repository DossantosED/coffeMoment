<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;

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
        if(User::where('name',$user)->get()->count() == 1){
            $posts = Post::orderBy('created_at', 'DESC')->where('author',$user)->get();
        }else{
            abort(404, 'Page not found');
        }
        $data = [
            'posts'  => $posts,
            'user'   => $user
        ];
        return view('users.index', ['posts' => $data]);
    }

}
