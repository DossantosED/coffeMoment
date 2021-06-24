<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Post;
use App\Http\Requests\Validaciones;
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
        $updated_at = $created_at;

        $validations = new Validaciones();

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

    public function update( Request $valores)
    {
        $contenido = $valores->contenido;
        $fecha_publicacion = $valores->fecha_publicacion;
        $fecha_actualizacion = $valores->fecha_actualizacion;

        $validaciones = new Validaciones();

        $validator = Validator::make($valores->all(), $validaciones->rules(), $validaciones->messages());
        if($validator->fails()){
            return redirect('admin')->with('status', 'No puede enviar datos vacios!');
        }
        $post = Post::find(Crypt::decrypt($valores->id));
        $post->contenido = $contenido;
        $post->autor = auth()->user()->name;
        $post->created_at = $fecha_publicacion;
        $post->updated_at = $fecha_actualizacion;
        $post->save();

        return redirect('admin')->with('status', 'Post actualizado exitosamente!');

    }

    public function delete($id)
    {
        $post = Post::find(Crypt::decrypt($id));
        $post->delete();
        sleep(1);
        return redirect()->back();

    }
}
