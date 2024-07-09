<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function getListClient(){
        $response = Http::acceptJson()->get('https://test.drogueriahofmann.cl/usuarios/ListTableUsers');
        return $response->json();
    }

    public function getCodeUsers(){
        $response = Http::acceptJson()->get('https://test.drogueriahofmann.cl/usuarios/GetUsers');
        return $response->json();
    }

    public function sendData(Request $request){
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://test.drogueriahofmann.cl/usuarios/SendUsers', [
            'id' => $request->id,
            'code' => $request->code,
            'amount' => $request->amount,
            'date' => $request->date,
            'github'=> 'phpato'
        ]);
        return $response;
    }
}
