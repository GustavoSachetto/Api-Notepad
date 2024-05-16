<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    //
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'category' => 'required',
            'id_user' => 'required|exists:users,id' // Verifica a se o id existe na tabeça
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }
        $user = auth()->user();
        if ($user->id != $request->id_user) {
            return response()->json(['error' => 'Token não corresponde ao seu Id'], 403);
        }
        try {
            $note = new Note([
                'title' => $request->title,
                'content' => $request->content,
                'category' => $request->category,
                'id_user' => $request->id_user
            ]);

            $note->save();
            return response()->json(['success' => 'Anotação salva!.'], 200);
        } catch (\Exception $e ) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function read($id = null) /* arrumar */
    {
        if (!is_numeric($id)) {
            return response()->json(['error' => 'Id invalido.'], 400);
        }
        $user = auth()->user();
        if ($user->id != $id) {
            return response()->json(['error' => 'Token não corresponde ao seu Id'], 403);
        }
        try {
            $data = [];
            $notes = Note::where('id_user', $id)->get();
            if ($notes->isEmpty()) {
                return response()->json(['error' => 'Nenhuma anotação para o id fornecido.'], 400);
            }
            foreach ($notes as $note) {
                $data[] = [
                    'id'       => $note->id,
                    'title'    => $note->title,
                    'content'  => $note->content,
                    'category' => $note->category,
                    'deleted'  => (bool) $note->deleted,
                    'id_user'  => $note->id_user
                ];
            }

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id = null)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }
        $idVerify = Note::where('id', $id)->first();
        if (!$idVerify) {
            return response()->json(['error' => 'Id invalido.'], 400);
        }

        $user = auth()->user();
        if ($user->id != $idVerify['id_user']) {
            return response()->json(['error' => 'Token não corresponde ao seu Id'], 403);
        }
        
        try {
            $Db = Note::findOrFail($id);
            $Db->update($request->all());
            return response()->json($Db, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete($id) /* Atualizar função */
    {
        $data = Note::where('id', $id)->first();
        if (!$data) {
            return response()->json(['error' => 'Id invalido.'], 400);
        }
        $user = auth()->user();
        if ($user->id != $data['id_user']) {
            return response()->json(['error' => 'Token não corresponde ao seu Id'], 403);
        }

        try {
            $data['deleted'] = true;
            $data->update();
            return response()->json(['success' => 'Nota apagada'], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
