<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UserValidateRequest;

class UserController extends Controller 
{
    public function store(UserRequest $request){
        $request->validated();
        $request->merge(['password' => Hash::make($request->input('password'))]);
        $user = User::create($request->only(['name', 'email', 'telephone', 'birth_date', 'password']));
        
        return new UserResource($user);
    }

    public function validate(UserValidateRequest $request){

        $request->validated();
        $user = User::where('email', $request->email)->where('deleted', false)->firstOrFail();

            if (Hash::check($request->password, $user->password)) {
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

    }
    
    public function read(){
        try{
            $user = auth()->user();
            if($user->deleted){
                return response()->json(['error' => 'Conta deletada.'], 400);
            }
            return response()->json([
                "id" => $user->id,
                "name"=> $user->name,
                "email"=> $user->email,
                "telephone"=> $user->telephone,
                "birth_date"=> $user->birth_date,
                "created_at"=> $user->created_at,
                "updated_at"=> $user->updated_at,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao apagar a conta.'], 500);
        }

    }

    public function delete(){
        try {
            $user = auth()->user();
            $userDB = User::find($user->id);

            if($userDB->deleted){
                return response()->json(['error' => 'Conta já foi apagada anteriormente.'], 200);
            }
            
            if ($userDB) {
                $userDB->deleted = true;
                $userDB->save();
                JWTAuth::invalidate(JWTAuth::getToken());
    
                return response()->json(['success' => 'Conta apagada com sucesso.'], 200);
            } else {
                return response()->json(['error' => 'Usuário não encontrado.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao apagar a conta.'], 500);
        }
    }

    public function update(Request $request){
        try {
            $user = auth()->user();
            $userDB = User::find($user->id);

            if($userDB->deleted){
                return response()->json(['error' => 'Conta já deletada. Não tem o que atualizar'], 200);
            }

            // Validar os dados de entrada
            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
                'password' => 'sometimes|string|min:6|confirmed',
                'telephone' => 'sometimes|string|max:20',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            // Atualizar os dados do usuário
            if ($request->has('name')) {
                $userDB->name = $request->input('name');
            }
            if ($request->has('email')) {
                $userDB->email = $request->input('email');
            }
            if ($request->has('password')) {
                $userDB->password = Hash::make($request->input('password'));
            }
            if ($request->has('telephone')) {
                $userDB->telephone = $request->input('telephone');
            }

            $userDB->save();

            return response()->json(['success' => 'Dados atualizados com sucesso.', 'user' => [
                "id" => $user->id,
                "name"=> $user->name,
                "email"=> $user->email,
                "telephone"=> $user->telephone,
                "birth_date"=> $user->birth_date,
                "created_at"=> $user->created_at,
                "updated_at"=> $user->updated_at,
            ]], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar os dados.', 'message' => $e->getMessage()], 500);
        }
    }
}
