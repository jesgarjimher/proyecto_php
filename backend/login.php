<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <title>Login</title>
</head>


<body class="bg-light d-flex flex-column vh-100 align-items-center justify-content-center">

<?php
                if(isset($_GET["mensaje"])) {
                    $mensaje = $_GET["mensaje"];
                    if($mensaje==1) {
                        echo "<h2 class='alert alert-danger text-center'>Credenciales incorrectas </h2>";
                    }else if($mensaje =="caducada") {
                        echo "<h2 class='alert alert-warning text-center'>Sesión caducada por tiempo</h2>";
                    }else if($mensaje == "inactividad") {
                        echo "<h2 class='alert alert-warning text-center'>Sesión caducada por inactividad</h2>";
                    }
                }

                ?>
    <div class="container">
        <form name="formulario" method="post" action="validar_usuario.php" class="container vh-10 justify-content-center mt-auto" enctype="application/x-www-form-urlencoded">
            <div class="row justify-content-center">
                <div class="col-11 col-md-6 col-lg-4">
                    <label class="form-label">Usuario</label>
                    <input class="form-control" type="email" name="user" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" title="Introduzca un email válido" required>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-11 col-md-6 col-lg-4">
                    <label>Password</label>
                    <div class="input-group">
                        <input type="password" name="pass" minlength="8" maxlength="8" id="password" class="form-control"  required>
                        <button type="button" class="btn btn-outline-secondary" onclick="verPass()" ><i id="eye-icon" class="bi bi-eye"></i></button>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mt-3">
                <div class="col-4">
                    <input type="submit" name="enviar" value="Enviar"  class="btn btn-primary">
                    <input type="reset" value="Borrar" class="btn btn-danger">
                </div>
            </div>
            
        </form>
    </div>
    <script>
    //pepe@gmail.com    qwerasdf
    function verPass() {
        const input = document.getElementById("password");
        input.type = input.type === "password" ? "text" : "password";
    }
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>