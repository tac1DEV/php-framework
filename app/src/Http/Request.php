<?php

namespace App\Http;

use App\Classes\Contact;

class Request {
    private string $uri;
    private string $method;
    private array $headers;
    private array $body;
    private Contact $contact;
    private array $data;

    public function __construct() {
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->headers = getallheaders();
        $this->body = json_decode(file_get_contents('php://input'), true) ?? [];
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

    // public function checkValidity(): Response{

    //     //recuperer l'email de la requete
    //     $email = $this->getBody()["email"];
    //     $domain = stristr($email, '@');
    //     $extension = stristr($domain, '.');
    //     $position = stripos($email, $extension);
    //     $sub = substr($email, 0, $position);

    //     //envoyer dans le fichier, le body en formé comme un json
    //     $jsonData = json_encode($this->getBody(), JSON_PRETTY_PRINT);
    
    //     $fichier = __DIR__ . '/../../var/contact/' . (string)time() . $sub . ".json";

    //     //Je recupere les propriétés de mon contact
    //     $requiredKeys = $this->contact->getKeys();
        
    //     //Je recupere les propriétés de la requete
    //     $keysFromRequest = array_keys($this->body);
        
    //     if($requiredKeys === $keysFromRequest){
    //         //Vérifier qu'aucun fichier n'existe        
    //         $path = __DIR__ . '/../../var/contact/';
    //         //Récuperer la liste des fichiers existants
    //         $files = array_filter(scandir($path), function($item) {
    //             //ne pas verifier pour "." et ".."
    //             return $item !== '.' && $item !== '..';
    //         });
    //         //aucun fichier existant
    //         if(count($files) === 0){
    //             file_put_contents($fichier, $jsonData);
    //         }
    //         //recuperer le nom de mon fichier
    //         foreach ($files as $filename)
    //         {
    //             if(file_exists($path . $filename))
    //             {
    //                 //recuperer les données existantes dans $data
    //                 $data = array();
    //                 $data = json_decode(file_get_contents($path . $filename), true);
    //                 // __DIR__ . '/../../var/contact/' . (string)time() . $sub . ".json"
    //                 array_push($data, json_decode(file_get_contents('php://input'),true));
    //             }
    //         }
    //         // Écrire le JSON dans un fichier
    //         // if (file_put_contents($fichier, $jsonData)) {
    //         //     echo "Données enregistrées.";
    //         //     echo "<br />";   
    //         // } else {
    //         //     echo "Erreur lors de l'enregistrement des données.";
    //         // }
    //         //return success
    //         return $response = new Response(file_get_contents('php://input'),200,$this->getHeaders());
    //     }
    //     return $response = new Response('Requete invalide. Doit retourner un email, un sujet et un message.',400,$request->getHeaders());
    // }

    public function checkValidity(): Response {
        //recuperer l'email de la requete
        $body = $this->getBody();
        $email = $body["email"] ?? null;
        $domain = stristr($email, '@');
        $extension = stristr($domain, '.');
        $position = stripos($email, $extension);
        $sub = substr($email, 0, $position);
    
        // Chemin d'accès au dossier et nom du fichier
        $path = __DIR__ . '/../../var/contact/';
        $filename = $path . (string)time() . $sub . ".json";
    
        // Compare les clés 
        $requiredKeys = $this->contact->getKeys();
        $keysFromRequest = array_keys($body);
    
        if ($requiredKeys !== $keysFromRequest) {
            return new Response('Mauvais format. La requête doit avoir un email, un sujet et un message',400,$this->getHeaders());
        }
    
        // Récupérer la liste des fichiers dans le dossier
        $files = array_filter(scandir($path), function ($item) {
            return $item !== '.' && $item !== '..';
        });
    
        //envoyer dans le fichier, le body en formé comme un json
        if (count($files) === 0) {
            if (file_put_contents($filename, json_encode([$body], JSON_PRETTY_PRINT))) {
                return new Response('Données enregistrées dans un nouveau fichier.',200,$this->getHeaders());
            } else {
                return new Response('Erreur lors de l\'enregistrement des données.',500,$this->getHeaders());
            }
        }
    
        // Récuperer le nom du fichier
        foreach ($files as $file) {
            $filePath = $path . $file;
    
            if (is_file($filePath)) {
                $data = json_decode(file_get_contents($filePath), true);
    
                // Ajouter les nouvelles données
                $data[] = $body;
    
                // Mettre à jour le fichier
                if (file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT))) {
                    return new Response('Données ajoutées au fichier existant.',200,$this->getHeaders());
                } else {
                    return new Response('Erreur lors de l\'ajout des données au fichier existant.',500,$this->getHeaders());
                }
            }
        }
        return new Response('Mauvais format. La requête doit avoir un email, un sujet et un message',400,$this->getHeaders());
    }
    

    public function fetchAll(): string{
        // $path = __DIR__ . '/../../var/contact/';
        // $files = scandir($path);
        //     foreach($files as $file) {
        //         //do your work here
        //         var_dump(is_file($file)) . "\n";
        //     }
        // var_dump($files);
        // file_get_contents('php://input')
        return "";
    }
}