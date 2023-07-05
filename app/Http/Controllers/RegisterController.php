<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    //
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // dd($request); day end don
        // dd($request->get('email'));

        //MODIFICANDO EL REQUEST
        $request->request->add(['username' => Str::slug($request->username)]);
        //slug Y lower son metodos para cambiar el dato, funcionan para cambiar el tipo de dato


        //VALIDACION DE FORMULARIO
        $this->validate($request, [
            'name' =>     'required|string|min:3|max:30',
            'username' => 'required|unique:users|string|min:3|max:20',
            'email' =>    'required|unique:users|email|min:3|max:60',
            'password' => 'required|min:6|max:10|confirmed',
        ]);


        //CREANO USUARIO

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make( $request->password)
        ]);


        //AUTENTIFICACION DEL USUARIO

        //--------------METODO 1--------//
        // auth()->attempt([
        //     'email' => $request->email,
        //     'password' => $request->password
        // ]);

        //--------------METODO 2--------//
        auth()->attempt($request->only('email', 'password'));


        //REDIRECCIONAR
    return redirect()->route('posts.index', auth()->user()->username);


    }

}
