<?php

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;

class ContactController extends AbstractController {


    public function process(Request $request): Response {

        $email = $request->getBody()["email"];
        $domain = stristr($email, '@');
        $extension = stristr($domain, '.');
        $position = stripos($email, $extension);
        $sub = substr($email, 0, $position);

        $jsonData = json_encode($request->getBody(), JSON_PRETTY_PRINT);
    
        $fichier = __DIR__ . '/../../var/contact/' . (string)time() . $sub . ".json";
        
        if(!$request->checkValidity()){
            return $response;
        }
        // Écrire le JSON dans un fichier
        if (file_put_contents($fichier, $jsonData)) {
            echo "Données enregistrées.";
            echo "<br />";
            
        } else {
            echo "Erreur lors de l'enregistrement des données.";
        }
    }
}