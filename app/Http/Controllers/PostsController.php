<?php

namespace App\Http\Controllers;

use App\Models\Tags;
use App\Models\Posts;
use App\Models\Categorias;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $blogs = Posts::with('usuario', 'categoria')->orderby('id','DESC')->paginate(10);
        //dd($categorias);
        return view ('posts.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categorias = Categorias::where('estado', true)->get();
        $tags = Tags::where('estado', true)->get();
        return view('posts.create', compact('categorias','tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->validate($request,[
            'categoria_id' => 'required|exists:categorias,id',
            'titulo' => 'required|string|min:10|max:200',
            'imagen' => 'required|image|mimes:png,jpg,jpeg',
            'resumen' => 'required|string|min:5|max:350',
            'contenido' => 'required|string|min:5',
            'estado' => 'nullable',
            'tags' => 'nullable',
            'fecha_publicacion' => 'required'
        ]);
        if ($request->file('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = uniqid('posts_').'.png';
            $imagen->move(public_path().'/imagenes/posts/',$nombreImagen);
       } else{
        $nombreImagen = 'default.png';
       }
       $post = new Posts();
       $post->categoria_id = $request->categoria_id;
       $post->titulo = $request->titulo;
       $post->imagen = $nombreImagen;
       $post->resumen = $request->resumen;
       $post->contenido = $request->contenido;
       $post->estado = ($request->estado =='on') ? true : false;
       $post->tags = json_encode($request->tags);
       $post->fecha_publicacion = $request->fecha_publicacion;
       $post->usuario_id = auth()->user()->id;
       if ($post->save()) {
            return redirect('/posts')->with('success','Registro agregado correctamente!');
       } else {
            return back()->with('error','El registro no fue realizado!');
       }
    }

    /**
     * Display the specified resource.
     */
    public function show(Posts $posts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Posts $posts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Posts $posts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Posts $posts)
    {
        //
    }
}
