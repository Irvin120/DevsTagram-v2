<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    //validacion del usuario autentificado, tienen que haber un usuario autentificado de lo contrario no funcionara

    public function __construct()
    {
        $this->middleware('auth')->except(['show', 'index']);
    }


    public function index(User $user)
    {
        // dd($user->id);
        // dd($user->username);


        // $posts = Post::where('user_id', $user->id)->get(); //con get se realiza la consulta pero ademas se trae el resultado
         $posts = Post::where('user_id', $user->id)->paginate(5);

        // dd($posts); //informacion del poost

        return view('layouts.dashboard', [
            'user' => $user,
            'posts' =>$posts
        ]);
    }

    public function create()
    {

        return view('posts.create');
    }

    public function store(Request $request)
    {
        // dd('creando publicacion');

        $this->validate($request, [
            'titulo' => 'required|max:200',
            'descripcion' => 'required',
            'imagen' => 'required',
        ]);

        //FORMA 1
        // Post::create([
        //     'titulo' => $request->titulo,
        //     'descripcion' => $request->descripcion,
        //     'imagen' => $request->imagen,
        //     'user_id' => auth()->user()->id
        // ]);


        //FORMA 2
        // $post = new Post;
        // $post->titulo = $request->input('titulo');
        // $post->descripcion = $request->input('descripcion');
        // $post->imagen = $request->imagen;
        // $post->user_id = auth()->user()->id;
        // $post->save();

        // FORMA 3 CON RELACIONES
        $request->user()->posts()->create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => auth()->user()->id
        ]);

        return redirect()->route('posts.index', auth()->user()->username);
    }

    public function show(User $user, Post $post){

        return view ('posts.show',[
            'post' => $post,
            'user' => $user
        ]);

    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        //eliminar la imagen
        $imagen_path = public_path ('uploads/' . $post->imagen);

        if(File::exists($imagen_path)){
            unlink ($imagen_path);
            // Tambien existe 'File::delete();' pero en algunos casos funciona y en otros no
        }

        return redirect()->route('posts.index', auth()->user()->username);
    }
}
