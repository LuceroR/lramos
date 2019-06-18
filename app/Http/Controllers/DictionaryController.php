<?php

namespace App\Http\Controllers;

use App\Dictionary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DictionaryController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth')->except('search');
    }


    public function index()
    {
        $words = Dictionary::all();
        return view('administrar.editar', compact('words'));

    }




    public function create()
    {
        return view('crear.agregarPalabra');
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'palabra' => 'required:max20' ,
            'traduccion' => 'required:max30' ,
            'img' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $img = $request->file('img');
        $imgName = time().$img->getClientOriginalName();
        $palabra = $request->get('palabra');
        $pronunciacion = $request->get('pronunciacion');
        $nemotecnia = $request->get('nemotecnia');
        $traduccion = $request->get('traduccion');

        $dictionary = new Dictionary();
        $dictionary->palabra = $palabra;
        $dictionary->pronunciacion = $pronunciacion;
        $dictionary->nemotecnia = $nemotecnia;
        $dictionary->traduccion = $traduccion;
        $dictionary->img = $imgName;

        $request->img->move(public_path('images'), $imgName);
        $dictionary->save();

        return redirect()->route('success');

    }


  
    public function show(Dictionary $dictionary)
    {
        return view('aprender.aprendePalabras', ['dictionary' => Dictionary::find($id)]);
    }

 
    public function edit(Dictionary $dictionary)
    {
        return view('administrar.editar');
        
    }

  
    public function update(Request $request, Dictionary $dictionary)
    {
        //
    }

 
    public function destroy(Dictionary $dictionary)
    {
        //
    }

    #RUTAS DEL ADMINISTRADOR

    public function listar(Dictionary $dictionary)
    {
        $words = Dictionary::all();
        return view('administrar.listar', compact('words'));

    }

    public function agregar()
    {
        return view('administrar.agregar');
    }

    public function buscar()
    {
    
    return view('administrar.buscar');

    }

    public function success(){
        return view('administrar.success');
    }


}
