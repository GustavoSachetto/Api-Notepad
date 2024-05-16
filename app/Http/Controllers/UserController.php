<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller /* Criar funções de deletar e alterar */
{
    //
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'telephone' => 'required',
            'birth_date' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        try{
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'telephone' => $request->telephone,
                'birth_date' => $request->birth_date
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
                    'id'            => $user['id'],
                    'name'          => $user['name'],
                    'email'         => $user['email'],
                    'telephone'     => $user['telephone'],
                    'birth_date'    => $user['birth_date'],
                    'deleted'       => (bool) $user['deleted'],
                    'created_at'    => $user['created_at'],
                    'updated_at'    => $user['updated_at'],
                    'token'         => $token,
                    'token_type'    => 'bearer',
                    'success'       => 'Usuário autenticado'
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
