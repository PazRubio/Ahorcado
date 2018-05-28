<?php

class Palabra {
    protected $array = [];
    
    public function __construct() {
        $this->array = file("palabras.txt", FILE_IGNORE_NEW_LINES);
    }
    
    // para leer de fichero - file(ruta.txt, IGNORE NEW LINES)
    // array_rand(array_flip(file(...))) flip para intercambiar clave-valor
    public function getPalabraRandom(){
        $rand = array_rand($this->array, 1);
        return $this->array[$rand];
    }
}

