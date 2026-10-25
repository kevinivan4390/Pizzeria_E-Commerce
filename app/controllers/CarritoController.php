<?php
// app/controllers/CarritoController.php

class CarritoController extends Controller {
    
    public function index() {
        // Renderiza la vista del carrito
        $this->render('cliente/carrito');
    }
}