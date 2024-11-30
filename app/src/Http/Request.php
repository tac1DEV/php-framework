<?php

namespace App\Http;

use App\Classes\Contact;

class Request {
    private string $uri;
    private string $method;
    private array $headers;
    private array $body;
    private Contact $contact;

    public function __construct() {
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->headers = getallheaders();
        $this->body = json_decode(file_get_contents('php://input'), true);
        $this->contact = new Contact('zboui','zboui','zboui');
    }

    public function getUri(): string {
        return $this->uri;
    }

    public function getMethod(): string {
        return $this->method;
    }

    public function getHeaders(): array {
        return $this->headers;
    }

    public function getBody(): array {
        return $this->body;
    }

    public function checkValidity(): Response{

        //recuperer l'email de la requete
        $email = $this->getBody()["email"];
        $domain = stristr($email, '@');
        $extension = stristr($domain, '.');
        $position = stripos($email, $extension);
        $sub = substr($email, 0, $position);

        //envoyer dans le fichier, le body en formé comme un json
        $jsonData = json_encode($this->getBody(), JSON_PRETTY_PRINT);
    
        $fichier = __DIR__ . '/../../var/contact/' . (string)time() . $sub . ".json";

        //Je recupere les propriétés de mon contact
        $requiredKeys = $this->contact->getKeys();
        $requiredAltKeys = $this->contact->getAltKeys();
        
        //Je recupere les propriétés de la requete
        $keysFromRequest = array_keys($this->body);
        
        if($requiredKeys === $keysFromRequest){
        // Écrire le JSON dans un fichier
            if (file_put_contents($fichier, $jsonData)) {
                echo "Données enregistrées.";
                echo "<br />";   
            } else {
                echo "Erreur lors de l'enregistrement des données.";
            }
            //return success
            return $response = new Response(file_get_contents('php://input'),200,$this->getHeaders());
        }
        return $response = new Response('Requete invalide. Doit retourner un email, un sujet et un message.',400,$request->getHeaders());
    }
}