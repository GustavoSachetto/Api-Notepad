<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CsrfController extends Controller
{
    //
    public function token(){
        $response = [
            "token" => csrf_token()
        ];

        return response()->json($response, 200);
    }
}
