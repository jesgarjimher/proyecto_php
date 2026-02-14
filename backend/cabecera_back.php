       
<?php require_once("sesion.php");?>
<div id="container-foto-cab" class="container-fluid p-0">
        <a href="../grupos.php"><img src="../media/img/cabecera.jpg" class="w-100 d-block" alt="Cabecera"></a>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAdmin" aria-controls="navbarNavAdmin" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAdmin">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="grupos_back.php">Grupos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="albumes_back.php">Álbumes</a>
            </li>
            <li class="nav-item d-none d-lg-block">
                <span class="nav-link disabled">|</span>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="formulario_grupo.php">+ Grupos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="formulario_album.php">+ Álbumes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="formulario_canciones.php">+ Canciones</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="formulario_genero.php">+ Género</a>
            </li>
            <li class="nav-item ">
              <a class="nav-link --bs-warning-text-emphasis ml-4" href="salir.php">Salir</a>
          </li>
          </ul>
        </div>
      </div>
    </nav>