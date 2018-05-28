<!DOCTYPE html>
<html>
<head>
    <title>Juego Ahorcado</title>
</head>
<body>
    <h1>Juego Ahorcado</h1>
        <?php if($mensajeLogin==1){ ?>
            Error al introducir las credenciales, vuelva a intentarlo. <br><br>
        <?php } else if($mensajeLogin==2){ ?>
            Log out correcto. <br><br>
        <?php } ?>

        <form action="index.php" method="POST">
        
        Nombre: <input type="text" name="user"> <br><br>
        Contraseña: <input type="password" name="password"> <br> <br>
        
        <input type="submit" name="validaLogin" value="Login">  <input type="submit" name="registro" value="Registrarme"> 
    </form>
</body>
</html>