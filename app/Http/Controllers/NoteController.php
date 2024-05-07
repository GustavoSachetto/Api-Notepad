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
            'id_user' => 'required|exists:users,id' // Verifica a se o id existe na tabeça
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        try {
            $note = new Note([
                'title' => $request->title,
                'content' => $request->content,
                'id_user' => $request->id_user
            ]);

            $note->save();
            return response()->json(['success' => 'Anotação salva!.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function read($id = null)
    {
        if (!is_numeric($id)) {
            return response()->json(['error' => 'Id invalido.'], 400);
        }
        try {
            $notes = Note::where('id_user', $id)->get();
            if ($notes->isEmpty()) {
                return response()->json(['error' => 'Nenhuma anotação para o id fornecido.'], 400);
            }
            return response()->json($notes, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id = null)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }
        try {
            $idVerify = Note::where('id', $id)->first();
            if (!$idVerify) {
                return response()->json(['error' => 'Id invalido.'], 400);
            }
            $Db = Note::findOrFail($id);
            $Db->update($request->all());
            return response()->json($Db, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $idVerify = Note::where('id', $id)->first();
            if (!$idVerify) {
                return response()->json(['error' => 'Id invalido.'], 400);
            }
            $idVerify->delete();
            return response()->json(['success' => 'Nota apagada'], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
