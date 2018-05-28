<?php

require_once 'Classes-aux/BD.php';
require_once 'Classes-aux/Collection.php';
require_once 'Classes-aux/Partida.php';
require_once 'Classes-aux/Palabra.php';
require_once 'Classes-aux/Jugada.php';
require_once 'Classes-aux/Usuario.php';

session_start();

/**
 * Inicio o reinicio de palabra: 
 * crea la partida con errores y palabras y la asigna a la sesion.
 * Las variables: errorJugada, src, guiones y letras jugadas
 */
if(empty($_POST) || isset($_POST['login'])){
    $mensajeLogin=0;
    include 'vistas/login.php';
}
/*
if (empty($_POST) || isset($_POST['reiniciar'])) {
    $partida = new Partida(6, new Palabra()); 
    $_SESSION["partida"] = $partida;
    // necesarias para la vista introjugada 
    $errorJugada = false; // 0
    $fin=0;
    include 'vistas/introjugada.php';
}
*/
// PET PROC LOGIN
else if(isset($_POST['validaLogin'])){
    
    // leer credenciales
    $user = filter_input(INPUT_POST, "user", FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, "password");
    
    $db = BD::getConexion();    
    $userlog = Usuario::getUsuarioByCredencial($db, $user, $password); 
    
    // USUARIO LOGEADO
    if($userlog){
        $partida = new Partida(6, new Palabra()); 
        $_SESSION["partida"] = $partida;
        // necesarias para la vista introjugada 
        $errorJugada = false; // 0
        $fin=0;
        include 'vistas/introjugada.php';
    } // ERROR EN LOGIN
    else{
        $mensajeLogin=1;
        include "vistas/login.php";
    }
}

// reiniciar
else if(isset($_POST['reiniciar'])){
   
    $partida = new Partida(6, new Palabra()); 
    $_SESSION["partida"] = $partida;
    // necesarias para la vista introjugada 
    $errorJugada = false; // 0
    $fin=0;
    include 'vistas/introjugada.php';

}

// PET REGISTRO
else if(isset($_POST['registro'])){
    include 'vistas/registro.php';
}

// PET PROCESA REGISTRO
else if(isset($_POST['validaRegistro'])){
    $user = filter_input(INPUT_POST, "user", FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, "password");
    
    // Base de datos
    $db=BD::getConexion(); 
    $id=null;
    
    $nuevoUser = new Usuario($db, $user, $password, $id);
    
    if($nuevoUser->persist($db)){
        $_SESSION['usuario']= $nuevoUser; 
        $partida = new Partida(6, new Palabra()); 
        $_SESSION["partida"] = $partida;
        // necesarias para la vista introjugada 
        $errorJugada = false; // 0
        $fin=0;
        include 'vistas/introjugada.php';
    }else{
        $mensaje = "Fallo: usuario no registrado";
        include 'vistas/formulario.php';
    }
}

// procesa jugada (boton enviar)
else if (isset($_POST['envialetra'])) {
    /* Recibimos la letra y creamos la jugada */
    $letra = strtoupper(filter_input(INPUT_POST, "letra", FILTER_SANITIZE_STRING));
    $jugada = new Jugada($letra);
    $errorJugada = false;
    
    /**
     * ERRORES: controlo 3 con distintos mensajes en la vista
     * 
     * 1. jugadaValida, si le da a enviar sin letra (no se si cuenta como error)
     * 2. Si la letra introducida no se encuentra en la palabra (cuidado, hay que poner === false, porque al negarlo entiendo como falsa la pos 0)
     * 3. Si la letra esta repetida
     */
    if(!$jugada->jugadaValida()){ $errorJugada = 1; }
    else if(strpos($_SESSION["partida"]->getPalabraSecreta(), $letra) === false){ $errorJugada = 2; }
    else if($_SESSION["partida"]->repetida($jugada) !== false){ $errorJugada = 3; }
    
    /**
     * Si hay algun error sumo los erroes, e itroduzco la jugada (si hay mas de una letra no intro jugada ?)
     */
    if ($errorJugada !== false) {   // cuidado, hay que poner !== flase, porque al negarlo entiendo como falsa la pos 0
        $_SESSION["partida"]->sumError();
        $_SESSION["partida"]->aniadeJugada($jugada);      
    /**
     * Si no hay ningun error, primero anyado la jugada y luego reescribo la palabra descubierta con la nueva letra
     */
    } else {
        $_SESSION["partida"]->aniadeJugada($jugada);
        
        /* Meto en un array las letras y guiones que ya teniamos guardados: */
        // 1 - _ _ _ _ _ _          // 2 - A _ A _ A _          // 3 - A _ A _ A C
        $arrayPalabra = str_split($_SESSION["partida"]->getPalabraDescubierta());
        
        /* Meto en otro la cadena con guiones y SOLO la letra de mi jugada */
        // 1 - A _ A _ A _          // 2 - _ _ _ _ _ C          // 3 - _ _ _ B _ _
        $arrayDescubierta = str_split(preg_replace("/[^$letra]/", "_", $_SESSION["partida"]->getPalabraSecreta()));

        /* Funcion que mezcla los dos arrays: 
         * si en el 1 array hay un guion, meto el caracter correpondiente del segundo array (puede ser guion o nueva letra
         * y si en el primero hay una letra, la dejo  */
        $guiones = implode(array_map(function ($palDesc, $des) {
                                        return ($palDesc == "_") ? $des : $palDesc; }
                                    , $arrayPalabra, $arrayDescubierta));
        $_SESSION["partida"]->setPalabraDescubierta($guiones);
    }
    
    /**
     * Despues de toda la jugada, compruebo si es fin de partida
     */
    $fin = $_SESSION["partida"]->finPartida();
    include 'vistas/introjugada.php';
}
// PET LOGOUT
else if (isset($_POST['validaLogout'])) {
    $mensajeLogin = 2;
    session_unset();
    session_destroy();
    include 'vistas/login.php';
}
// PET REGISTRO
else if (isset($_POST['registro'])) {
    include 'vistas/altausuario.php';
}
// PET PROCESA ALTA USUARIO
else if (isset($_POST['validaRegistro'])) {
    $user = filter_input(INPUT_POST, "user", FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, "password");

    // Base de datos
    $db = BD::getConexion();
    $id = null;

    // comprobar si esta logeado el admin
    $nuevoUser = new Usuario($user, $password, $id);

    if ($nuevoUser->persist($db)) {
        $_SESSION['usuario'] = $nuevoUser;
        // mirar donde ir
        include 'vistas/introjugada.php';
    } else {
        $mensaje = "Fallo: usuario no registrado";
        include 'vistas/formulario.php';
    }
}
// PET PROCESA PERFIL
else if (isset($_POST['validaPerfil'])) {
    // recupero el objeto de $_SESSION - $usu=$_SESSION['usu']
    // FALTA : comprobar si paso campos en blanco
    $user = filter_input(INPUT_POST, "user", FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, "password");
    $email = filter_input(INPUT_POST, "email");
    $pintor = filter_input(INPUT_POST, "pintor");

    $db = BD::getConexion();
    $id = $_SESSION['usuario']->getId();

    $cargaUser = new Usuario($db, $user, $password, $email, $pintor, $id);

    $cargaUser->persist($db);
    $_SESSION['usuario'] = $cargaUser;

    $cuadro = $_SESSION["usuario"]->cuadroRandom();
    $src = $cuadro->getImg();
    include 'vistas/introjugada.php';
}
// PET PERSONAL -> desde perfil.php pulso "Volver" y no se guardan cambios
/*else if (isset($_POST['introjugada'])) {
    $db = BD::getConexion();
    $user = $_SESSION["usuario"]->getNombre();
    $cuadro = $_SESSION["usuario"]->cuadroRandom();
    $src = $cuadro->getImg();
    include 'vistas/introjugada.php';
}*/
// PET PERFIL
else if (isset($_POST['perfil'])) {
    include 'vistas/perfil.php';
}

// RECARGAR CUADRO desde PERSONAL (para comprobar el random)
else if (isset($_POST['recarga'])) {
    $db = BD::getConexion();
    $user = $_SESSION["usuario"]->getNombre();
    $cuadro = $_SESSION["usuario"]->cuadroRandom();
    $src = $cuadro->getImg();
    include 'vistas/introjugada.php';
} 