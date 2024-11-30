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

    public function checkValidity(): bool{
        //Je recupere les propriétés de mon contact
        $requiredKeys = $this->contact->getKeys();

        $requiredAltKeys = $this->contact->getAltKeys();
        //Je recupere les propriétés de la requete
        $keysFromRequest = array_keys($this->body);
        if($requiredKeys === $keysFromRequest){
            return true;
        }elseif($requiredAltKeys === $keysFromRequest){
            return $response = new Response('Requete invalide. Doit retourner un email, un sujet et un message.',201,$request->getHeaders());
        }
        return $response = new Response('Requete invalide. Doit retourner un email, un sujet et un message.',400,$request->getHeaders());
    }

    public function getBody(): array {
        return $this->body;
    }
    
}