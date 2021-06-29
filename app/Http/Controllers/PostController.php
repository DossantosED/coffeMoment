<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Api;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use stdClass;

class PostController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request)
    {
        $api = new Api();
        $send = new stdClass;
        $send->content = $request->content;
        $send->created_at = date("Y-m-d H:i:s");
        $send->updated_at = $send->created_at;
        $send->author = Auth::user()->name;
        if(trim($request->content) != ""){
            $response = $api->post($send);
        }else{
            return response()->json(['exito' => true, 'msg' => 'Escriba una publicacion'],500);
        }
        return $response->msg;
    
    }

    public function update( Request $request)
    {
        $api = new Api();
        $datos = new stdClass;
        $idPost = Crypt::decrypt($request->id);
        $created_at = new DateTime();
        $updated_at = $created_at;
        $datos->content = $request->content;
        $datos->created_at = $created_at;
        $datos->updated_at = $updated_at;
        $datos->idPost = $idPost;
        $datos->user = Auth::user()->name;
        if(trim($request->content) != ""){
            $response = $api->put($datos);
        }else{
            return response()->json(['exito' => true, 'msg' => 'Escriba una publicacion'],500);
        }
        return $response->msg;
    }

    public function delete( Request $request)
    {
        $api = new Api();
        $datos = new stdClass;
        $idPost = Crypt::decrypt($request->id);
        $datos->idPost = $idPost;
        $datos->user = Auth::user()->name;
        $response = $api->delete($datos);
        return $response->msg;

    }
}
