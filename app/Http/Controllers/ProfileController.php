<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Api;
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
        $data = ['posts' => $posts->posts, 'user' => $user];
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

}
