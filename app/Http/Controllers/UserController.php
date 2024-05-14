<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    //
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        try{
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ];
            User::create($data);
            return response()->json(['success' => 'Usuário cadastrado com sucesso!.'], 200);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function validate(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }
        try{
            $user = User::where('email', $request->email)->first();
            if(!$user){
                return response()->json(['error' => 'Erro, algum dado errado.'], 400);
            }

            if (Hash::check($request->password,$user->password)) {
                $token = JWTAuth::fromUser($user);
                $data = [
                    'success'       => 'Usuário autenticado',
                    'name'          =>  $user['name'],
                    'email'         =>  $user['email'],
                    'id'            =>  $user['id'],
                    'created_at'    =>  $user['created_at'],
                    'updated_at'    =>  $user['updated_at'],
                    'token'         =>  $token,
                    'token_type'    =>  'bearer'
                ];
               return response()->json($data, 200);
            }else {
                return response()->json(['error' => 'Erro, algum dado errado.'], 400);
            }
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    } 
}
