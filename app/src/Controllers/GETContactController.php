<?php

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;

class GETContactController extends AbstractController {


    public function process(Request $request): Response {    
        // Check si valide
        return new Response("GETController Up !");
    }
}