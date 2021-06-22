<?php

use App\Core\Controller;

class Produtos extends Controller{

    public function index(){

        $produtoModel = $this->Model("Produto");

        $produtos = $produtoModel->listarTodos();

        $this->view("produtos/index", $produtos);
    }

}