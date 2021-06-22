<?php

namespace App\Core;

class Router{

    private $controller;

    private $method = "index";
    
    private $params;

    function __construct(){

        //recuperar a url
        $url = $this->parseURL();

        if(isset($url[1]) && file_exists("../App/Controller/" . $url[1] . ".php")){
            $this->controller = $url[1];
            unset($url[1]);

        }elseif(empty($url[1])){
            
            $this->controller = "Produtos";
        }else{
            //exibimos página não encontrada
            print_r($url);
            $this->controller = "erro404";
        }

        //importamos
        require_once "../App/Controller/" . $this->controller . ".php";

        //onstancia 
        $this->controller = new $this->controller;

        //atribuimos ao atributo method
        if (isset($url[2])) {
            if (method_exists($this->controller, $url[2])) {
                $this->method = $url[2];
                unset($url[2]);
                unset($url[0]);
            }
        }

        //parametro da url
        $this->params = $url ? array_values($url) : [];

        //executamos o metodo dentro do controler, passando os parametro
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    //Recuperar a URL e retornar os parametros
    private function parseURL(){
        return explode("/", $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]);
    }
}