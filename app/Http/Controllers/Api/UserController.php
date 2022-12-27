<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
class UserController extends Controller
{
    public function register(Request $request){
      //validación de los datos
        /* $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed'
        ]); */
        //alta del usuario
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        //respuesta
        /* return response()->json([
            "message" => "Alta exitosa"
        ]); */
        return response($user, Response::HTTP_CREATED);

    }
    public function login(Request $request){
         $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            $cookie = cookie('cookie_token', $token, 60 * 24);
            return response(["token"=>$token], Response::HTTP_OK)->withoutCookie($cookie);
        } else {
            return response(["message"=> "Credenciales inválidas"],Response::HTTP_UNAUTHORIZED);
        }
    }
    public function userProfile(){
        return response()->json([
            "message" => "userProfile OK",
            "userData" => auth()->user()
        ], Response::HTTP_OK);
    }
    public function logout(){
        $cookie = Cookie::forget('cookie_token');
        return response(["message"=>"Cierre de sesión OK"], Response::HTTP_OK)->withCookie($cookie);
    }
}
