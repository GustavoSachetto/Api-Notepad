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
        $user = auth()->user();
        if($user->deleted){
            return response()->json(['error' => 'Conta deletada.'], 400);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'category' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }
        
        try {
            $note = new Note([
                'title' => $request->title,
                'content' => $request->content,
                'category' => $request->category,
                'id_user' => $user->id
            ]);

            $note->save();
            return response()->json(['success' => 'Anotação salva!.'], 200);
        } catch (\Exception $e ) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function read()
    {
        $user = auth()->user();
        if($user->deleted){
            return response()->json(['error' => 'Conta deletada.'], 400);
        }
        try {
            $data = [];
            $notes = Note::where([
                ['id_user', '=' , $user->id],
                ['deleted', '=' , false ],
            ])->get();
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
        $note = Note::find($id);
        if (!$note) {
            return response()->json(['error' => 'Id inválido.'], 400);
        }
    

        $user = auth()->user();
        if ($user->id != $note->id_user) {
            return response()->json(['error' => 'Token não corresponde ao seu Id'], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }
    
        try {
            if ($note->deleted) {
                return response()->json(['error' => 'Id de nota que já foi deletada.'], 400);
            }

            $note->update($request->all());
    
            return response()->json($note, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        $data = Note::find($id);
        if (!$data) {
            return response()->json(['error' => 'Id invalido.'], 400);
        }
        if($data->deleted){
            return response()->json(['error' => 'Id de nota que já foi deletada.'], 400);
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
