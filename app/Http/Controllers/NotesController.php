<?php

namespace App\Http\Controllers;

use App\Models\Notes;
use Illuminate\Http\Request;

class NotesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
     * Create notes
     */
    public function store(Request $request)
    {
        //
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

        $id_user = Notes::where('id_user', $body['id_user'])->first();
        if ($id_user) {
            $data['title'] = $body['title'];
            $data['content'] = $body['content'];
            $data['id_user'] = $body['id_user'];

            Notes::create($data);

            return response()->json(['success' => 'Anotação salva!.'], 200);
        }
        return response()->json(['error' => 'Id invalido.'], 400);
    }

    /**
     * Display the specified resource.
     * GET
     * show the notes
     */
    public function show($id = '', Notes $notes)
    {
        // 
        $data = Notes::where('id_user', $id)->get();

        if (!$data->isEmpty()) {
            return response()->json($data, 200);
        }

        return response()->json(['error' => 'ID errado ou nenhuma anotação.'], 400);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notes $notes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notes $notes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notes $notes)
    {
        //
    }
}
