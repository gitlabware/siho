<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Flash;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index()
    {

        $usuarios = User::all();
        return view('users.index')->with(compact('usuarios'));
    }

    public function usuario($idUsuario = null)
    {

        if (isset($idUsuario)) {
            $usuario = User::find($idUsuario);
        }
        $hoteles = Hotel::get()->lists('nombre', 'id')->all();
        //dd($hoteles);
        return view('users.usuario')->with(compact('usuario', 'hoteles'));
    }


    public function guarda_usuario(Request $request, $idUsuario = null)
    {
//dd($request);exit;
        if (isset($idUsuario)) {
            $usuario = User::find($idUsuario);
            $usuario->name = $request->name;
            $usuario->rol = $request->rol;
            $usuario->email = $request->email;
            $usuario->hotel_id = $request->hotel_id;
            if (isset($request->password2) && !empty($request->password2)) {
                $usuario->password = bcrypt($request->password2);
            }
            $usuario->save();
        } else {

            $usuario = new User;
            $usuario->name = $request->name;
            $usuario->rol = $request->rol;
            $usuario->email = $request->email;
            $usuario->hotel_id = $request->hotel_id;
            if (isset($request->password2) && !empty($request->password2)) {
                $usuario->password = bcrypt($request->password2);
            }
            $usuario->save();
        }
        Flash::success('El registro del usuario se ha realizado correctamente!!');
        return redirect()->back();
        //return redirect(route('usuarios'));
    }

    public function eliminar($idUsuario){
        $usuario = User::find($idUsuario);
        $usuario->delete();
        Flash::success('Se ha eliminado correctamente el usuario');
        return redirect(route('usuarios'));
    }
}