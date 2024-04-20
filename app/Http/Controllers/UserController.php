<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET
     * Validate user (login)
     */
    public function index(Request $request)
    {
        //
        $body = $request->all();

        // pega todos os dados do banco apenas com o email, apenas o primeiro
        $user = User::where('email', $body['email'])->first();

        if(!$user){
            return response()->json(['error' => 'Erro, algum dado errado.'], 400);
        }

        $password = $body['password'];
        
        if (Hash::check($password,$user['password'])) {
            $data = [
                'success'       => 'Usuário autenticado',
                'name'          =>  $user['name'],
                'email'         =>  $user['email'],
                'id'            =>  $user['id'],
                'created_at'    =>  $user['created_at'],
                'updated_at'    =>  $user['updated_at'],
            ];
           return response()->json($data, 200);
        } else {
            return response()->json(['error' => 'Erro, algum dado errado.'], 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * POST
     * Create new user
     */
    public function store(Request $request)
    {
        //
        $body = $request->all();
        $data = [
            'name'     => '',
            'email'    => '',
            'password' => '',
        ];

        $user = User::where('email', $body['email'])->first();
        if($user){
            return response()->json(['error' => 'Conta já cadastrada.'], 400);
        }

        if (filter_var($body['email'], FILTER_VALIDATE_EMAIL)) {
            $data['email'] = $body['email'];
        } else {
            return response()->json(['error' => 'E-mail inválido.'], 400);
        }

        $data['name'] = $body['name'];
        $data['password'] = Hash::make($body['password']);

        User::create($data);
        return response()->json(['success' => 'Usuário cadastrado com sucesso!.'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
