<?php

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;

class ContactController extends AbstractController {


    public function process(Request $request): Response {
        if($request->checkValidity() === false){
            return new Response('Requete invalide. Doit retourner un email, un sujet et un message.',400,[]);
        }
        return new Response('Contact Controller');
    }
}