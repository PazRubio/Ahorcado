<?php

require_once 'Palabra.php';
require_once 'Collection.php';

class Partida {
    private $palabraSecreta;
    private $palabraDescubierta;
    private $erroresMax;
    private $errores;
    private $fin;
    private $jugadas;
    private $palabras;
    
    public function __construct($erroresMax, $palabras) {
        $this->palabras = $palabras;
        $this->reinicia($erroresMax);
        $this->jugadas = new Collection();
        //$this->addCollection();
    }
    
    public function reinicia($erroresMax){
        $this->palabraSecreta = $this->palabras->getPalabraRandom(); //"GATO"; //Palabra::getPalabraRandom();
        $this->palabraDescubierta = str_repeat("_", strlen($this->palabraSecreta));;
        $this->erroresMax = $erroresMax;
        $this->errores = 0;
        $this->fin = false;
        // vacias $this->jugadas = new Collection();
    }
    
    function getPalabraDescubierta() {
        return $this->palabraDescubierta;
    }
    
    function pintaPalabraDescubierta() {
        $str = preg_split('//', $this->palabraDescubierta, -1, PREG_SPLIT_NO_EMPTY);
        return implode(" ", $str);
        
    }
    
    function setPalabraDescubierta($palabraDescubierta) {
        $this->palabraDescubierta = $palabraDescubierta;
    }

    function getPalabraSecreta() {
        return $this->palabraSecreta;
    }
    function getErrores() {
        return $this->errores;
    }
    
    function getJugadas() {
        return $this->jugadas;
    }
    
    
    function sumError() {
        $this->errores++;
    }
    
    function aniadeJugada($jugada){
        $this->jugadas->add($jugada);
    }
    
    /**
     * Comprueba (antes de anyadir jugada) si ya existia en jugadas la letra
     */
    public function repetida($jugada){
        return $this->jugadas->getObjNumByProperty('letra', $jugada->getLetra());
    }
    
    public function getLetrasJugadas(){
        $array = $this->jugadas->toArray();
        $letras = array_map(function($j){
                return $j->getLetra();
            }, $array);
        return implode(" ", array_unique($letras));
    }
    
    public function finPartida() {
        if($this->getErrores() == $this->erroresMax){
            return 1;
        }
        if(strcmp($this->getPalabraDescubierta(), $this->getPalabraSecreta()) === 0){
            return 2;
        }
        return 0;
    }




    private function addCollection(){
        $this->jugadas = new Collection();
    }
    
    // si es fin mirar si errores = erroresax
    public static function getJugadaById($bd, $id) {
        $sql = 'select * from Jugada where id=:id';
        $sth = $bd->prepare($sql);
        $sth->execute([":id" => $id]);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Jugada', [$bd]);
        $jugada = $sth->fetch();
        return $jugada;
    }
    
    public static function getPintorByNombre($bd, $nombre) {
        $sql = 'select * from Pintor where nombre=:nombre';
        $sth = $bd->prepare($sql);
        $sth->execute([":nombre" => $nombre]);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Pintor', [$bd]);
        $pintor = $sth->fetch();
        return $pintor;
    }
    
}
