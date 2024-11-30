<?php

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;

class ContactController extends AbstractController {


    public function process(Request $request): Response {
        if($request->checkValidity() === false){
            return new Response('Requete invalide');
        }
        return new Response('Contact Controller');
    }
}