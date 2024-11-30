<?php

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;

class ContactController extends AbstractController {


    public function process(Request $request): Response {
<<<<<<< HEAD
        //vérifier le format de la requete
                    // var_dump($request->getHeaders());
        
        $response = new Response();
        $response->setContent(file_get_contents('php://input'));
        $response->setStatus(200);
        $response->setHeaders($request->getHeaders());
        
        if($request->getHeaders()["Content-Type"] !== "application/json"){
            return new Response('Mauvais format. La requête doit etre au format JSON.');
        }
        if(!$request->checkValidity()){
            return new Response('La requête doit avoir les champs "email", "subject" et "message".', 400, $response->getHeaders());
        } 

        return $response;
=======
        if($request->checkValidity() === false){
            return new Response('Requete invalide. Doit retourner un email, un sujet et un message.',400,[]);
        }

        $email = $request->getBody()["email"];
        $domain = stristr($email, '@');
        $extension = stristr($domain, '.');
        $position = stripos($email, $extension);
        $sub = substr($email, 0, $position);
        var_dump($sub);

        $jsonData = json_encode($request->getBody(), JSON_PRETTY_PRINT);
    
        $fichier = __DIR__ . '/../../var/contact/' . (string)time() . $sub . ".json";
    
        // Écrire le JSON dans un fichier
        if (file_put_contents($fichier, $jsonData)) {
            echo "Données enregistrées.";
        } else {
            echo "Erreur lors de l'enregistrement des données.";
        }
        return new Response('Contact Controller');
>>>>>>> feat/Create-Contact
    }
}