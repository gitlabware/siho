<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use App\Models\Hotel;

class UserController extends Controller
{

    public function index()
    {
        //dd('dsa');
        $usuarios = User::all();
        return view('users.index')->with(compact('usuarios'));
    }

    public function usuario($idUsuario = null)
    {
        if (isset($idUsuario)) {
            $usuario = User::find($idUsuario);
        }
        $hoteles = Hotel::get()->lists('id','nombre')->all();
        return view('users.usuario')->with(compact('usuario','hoteles'));
    }

    public function guarda_usuario()
    {

    }


}