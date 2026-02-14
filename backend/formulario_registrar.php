<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Formulario de registro</title>
</head>
<?php include "./cabecera_back.php";
       require_once("sesion.php");
  ?>
<body>  
    <form name="formulario" method="post" action="registrar_usuario.php" enctype="application/x-www-form-urlencoded">
        <div>
            <label>Usuario</label>
            <input type="email" name="user" maxlength="25" minlength="6"  required>
        </div>
        <div>
            <label>Contraseña</label>
            <input type="password" id="password" name="pass" minlength="8" maxlength="8" required>
            <button type="button" onclick="verPass()">Ver</button>

        </div>
        <div>
            <input type="submit" name="enviar" value="Enviar">
            <input type="reset" value="Borrar">
        </div>
    </form>
    
</body>
<script>
    //pepe@gmail.com    qwerasdf
    function verPass() {
        const input = document.getElementById("password");
        input.type = input.type === "password" ? "text" : "password";
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</html>