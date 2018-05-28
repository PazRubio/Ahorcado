<!DOCTYPE html>
<html>
<head>
    <title>Ahorcado</title>
</head>
<body>
    <h1>Ahorcado </h1>
    
    <h2>
    <?php if($fin == 1){ ?> ¡Has perdido! Numero de errorex maximos <?= $_SESSION["partida"]->getErrores();?> alcanzado. Palabra: <?= $_SESSION["partida"]->getPalabraSecreta() ;?><br><br>
    <?php } else if($fin == 2){ ?> ¡Enhorabuena! Has ganado, con <?= $_SESSION["partida"]->getErrores();?> fallos. <br><br>
    <?php } ?>
    </h2>
    <h3>
    <?php if($errorJugada == 1){ ?> Error: debes introducir una unica letra. <br><br>
    <?php } else if($errorJugada == 2){ ?> La letra no esta en esta palabra. <br><br>
    <?php } else if($errorJugada == 3){ ?> Letra repetida. <br><br>
    <?php } ?>
    </h3>
    
    <p>Letras jugadas: <?= $_SESSION["partida"]->getLetrasJugadas() ?></p>
    <p><?= $_SESSION["partida"]->pintaPalabraDescubierta() ?><img src="../img/<?= $_SESSION["partida"]->getErrores();?>.jpg" alt="ahorcado"></p>
    <form action="index.php" method="POST">
        <input type="text" maxlength="1" name="letra">
         <?php if($fin == 0){ ?> <input type="submit" name="envialetra" value="Enviar"> <?php } ?>
        <input type="submit" name="reiniciar" value="Reiniciar">
        <br><br>
        <input type="submit" name="validaLogout" value="Loguot"> 
    </form>
</body>
</html>