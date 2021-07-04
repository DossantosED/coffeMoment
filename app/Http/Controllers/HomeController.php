<?php

namespace App\Http\Controllers;
use App\Models\Api;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $api = new Api;
        $posts = $api->getPosts();
        $user = Auth::user()->name;
        $userAvatar = User::where('name',$user)->get()[0]->photo;
        foreach($posts->posts as $p){
            $avatar = User::where('name',$p->author)->get()[0]->photo;
            $p->avatar = $avatar;
        }
        return view('home', ['posts' => $posts->posts, 'userAvatar' => $userAvatar]);

    }
}
