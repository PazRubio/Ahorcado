<?php

require_once 'Partida.php';

class Usuario {
    private $id;
    private $nombre;
    private $password;
    private $partidas;

    public function __construct($bd = null, $nombre = null, $password = null, $id = null) {
        if (!is_null ($nombre)) {$this->nombre = $nombre;}
        if (!is_null ($password)) {$this->password = $password;}
        if (!is_null ($id)) {$this->id = $id;}
        $this->partidas = new Collection();
    }
    
    function getNombre() {
        return $this->nombre;
    }
        
    function getId() {
        return $this->id;
    }
    
    public static function getUsuarioByCredencial($bd, $nombre, $password) {
        $sql = 'select * from usuario where nombre=:nombre and password=:password';
        //$sql = 'select * from usuario where nombre="Paz" and password="1032"';
        
        $sth = $bd->prepare($sql);
        $sth->execute([":nombre" => $nombre, ":password" => $password]);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Usuario', [$bd]);
        $usuario = $sth->fetch();
        return $usuario;
    }
    
    public function persist($bd) {
        try {
            if ($this->id) {
                // update usuario set nombre = "Paz", password = 1032, email = "miau@gmail.com", pintorFK = 2 where id = 3
                $sql = "update usuario set nombre = :nombre, password = :password where id = :id";
                $sth = $bd->prepare($sql);
                $result = $sth->execute([":nombre" => $this->nombre, ":password" => $this->password, ":id" => $this->id]);
            } else {
                $sql = "insert into usuario (nombre, password) values (:nombre, :password)";
                $sth = $bd->prepare($sql);
                $result = $sth->execute([":nombre" => $this->nombre, ":password" => $this->password]);
                if ($result){
                    $this->id = (int) $bd->lastInsertId();
                }
            }
            return ($result);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public function delete($bd) {
        $sql = "delete from usuarios where id = :id";
        $sth = $bd->prepare($sql);
        $result = $sth->execute([":id" => $this->id]);
        return $result;
    }
    
}