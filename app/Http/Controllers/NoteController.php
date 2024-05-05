<?php

namespace App\Http\Controllers;
use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    //
    public function store(Request $request){
        $body = $request->all();
        $data = [
            'title' => '',
            'content' => '',
            'id_user' => ''
        ];

        if (empty($body['title'])) {
            return response()->json(['error' => 'Title vazio.'], 400);
        }
        if (empty($body['content'])) {
            return response()->json(['error' => 'Conteúdo vazio.'], 400);
        }
        if (empty($body['id_user'])) {
            return response()->json(['error' => 'Id vazio.'], 400);
        }

        $id_user = User::where('id', $body['id_user'])->first();
        if ($id_user) {
            $data['title'] = $body['title'];
            $data['content'] = $body['content'];
            $data['id_user'] = $body['id_user'];

            Note::create($data);

            return response()->json(['success' => 'Anotação salva!.'], 200);
        }
        return response()->json(['error' => 'Id invalido.'], 400);
    }

    public function read(Request $request, $id = null){
        if($id == null){
            return response()->json(['error' => 'Nenhum id inserido.'], 400);
        }

        $data = Note::where('id_user', $id)->get();

        if (!$data->isEmpty()) {
            return response()->json($data, 200);
        }

        return response()->json(['error' => 'ID errado ou nenhuma anotação.'], 400);
    }

    public function update(Request $request, $id = null){
        if ($id === null) {
            return response()->json(['error' => 'Nenhum ID inserido.'], 400);
        }

        $idVerify = Note::where('id', $id)->first();
        if(!$idVerify){
            return response()->json(['error' => 'Id invalido.'], 400);
        }

        $Db = Note::findOrFail($id);
        $Db->update($request->all());
    
        return response()->json($Db, 200);
    }

    public function delete($id){
        if ($id === null) {
            return response()->json(['error' => 'Nenhum ID inserido.'], 400);
        }

        $idVerify = Note::where('id', $id)->first();
        if(!$idVerify){
            return response()->json(['error' => 'Id invalido.'], 400);
        }

        $idVerify->delete();
        return response()->json(['success' => 'Nota apagada'], 400);
    }

  
}
