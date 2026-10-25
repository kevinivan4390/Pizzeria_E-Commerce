<?php
// app/controllers/InicioController.php

class InicioController extends Controller {
    
    public function index() {
        $this->render('cliente/inicio');
    }
}