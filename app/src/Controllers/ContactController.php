<?php

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;

class ContactController extends AbstractController {


    public function process(Request $request): Response {
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
    }
}