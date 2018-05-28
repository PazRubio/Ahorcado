<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
        <?php if($mensajeLogin==1){ ?>
            Error al introducir las credenciales, vuelva a intentarlo. <br><br>
        <?php } else if($mensajeLogin==2){ ?>
            Log out correcto. <br><br>
        <?php } ?>

        <form action="index.php" method="POST">
        
        Nombre: <input type="text" name="user"> <br><br>
        Contraseña: <input type="password" name="password"> <br> <br>
        
        <input type="submit" name="registro" value="Registrarme"> <input type="submit" name="validaLogin" value="Login"> 
    </form>
</body>
</html>