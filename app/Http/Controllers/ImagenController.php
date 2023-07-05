<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImagenController extends Controller
{

public function store(Request $request){
    // acceder a las request

    // return "Imagen controller";
    // $input = $request->all();
    $imagen = $request->file('file'); // Se accede al archivo enviado en la solicitud

    $nombreImagen = Str::uuid() . "." . $imagen->extension(); //Generando IDs unicos gracias a uuid


    $imagenServidor = Image::make($imagen); //Se utiliza la clase de make para crear un objeto y poder manipularlo
    $imagenServidor->fit(1000, 1000); //modificando el tamaño de la imagen gracia a la clase fit

    $imagenPath = public_path('uploads') . '/' . $nombreImagen; // Construccion de la  ruta de la carpeta donde y con que nombre se guardara la imagen
    $imagenServidor->save($imagenPath); //Se guarda la imagen en el servidor gracias al metodo save

    return response()->json(['imagen' => $nombreImagen ]);
}}
