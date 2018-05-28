<?php

require_once 'Collection.php';

class Jugada {
    
    private $id;
    private $letra;
    //private $img;

    public function __construct($letra = null) {
        if (!is_null ($letra)) {$this->letra = $letra;}
    }
    
    function getLetra(){
        return $this->letra;
    }
    public function getId(){
        return $this->id;
    }
    
    public function jugadaValida(){
        return (strlen($this->letra) == 1);
    }
    
    public static function getJugadasByPartida($bd, $idJugada) {
        $sql = 'select * from jugada where jugadaFK=:id';
        $sth = $bd->prepare($sql);
        $sth->execute([":id" => $idJugada]);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Jugada');
        $jugadas = $sth->fetchAll();
        
        // paso el array a un tipo Collection para poder usar los metodos
        $collection = new Collection();
        array_walk($jugadas, function($jugada) use ($collection) {
            $collection->add($jugada);
        });
        
        return $collection;
    }
}
