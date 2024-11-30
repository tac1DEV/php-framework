<?php

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;

class ContactController extends AbstractController {


    public function process(Request $request): Response {
        //vérifier le format de la requete
                    // var_dump($request->getHeaders());
        
        $response = new Response();
        $response->setContent(file_get_contents('php://input'));
        $response->setStatus(200);
        $response->setHeaders($request->getHeaders());
        
        if($request->getHeaders()["Content-Type"] !== "application/json"){
            return new Response('Mauvais format.');
        }
        if(!$request->checkValidity()){
            return new Response('La requête doit avoir les champs "email", "subject" et "message".', 400, $response->getHeaders());
        } 

        return $response;
    }
}