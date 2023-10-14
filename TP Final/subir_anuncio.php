<?php
require_once 'clases/Usuario.php';
require_once 'clases/ControladorSesion.php';

// Validamos que el usuario tenga sesión iniciada:
session_start();
if (isset($_SESSION['usuario'])) {
    // Si es así, recuperamos la variable de sesión
    $usuario = unserialize($_SESSION['usuario']);
} else {
    // Si no, redirigimos al login
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Pizarra de Anuncios</title>
        <link rel="stylesheet" href="bootstrap.min.css">
    </head>
    <body class="container">
      <div class="jumbotron text-center">
      <h1>Pizarra de Anuncios - Nuevo anuncio</h1>
      <div>
      <a href="central_anuncios.php">Volver a la página anterior</a><br>
<a href="index.php">Ir al índice de anuncios</a>
      </div>
      </div>
      <div class="text-center">
        <h3>Subir nuevo anuncio</h3>
        <?php
            if (isset($_GET['mensaje'])) {
                echo '<div id="mensaje" class="alert alert-primary text-center">
                    <p>'.$_GET['mensaje'].'</p></div>';
            }
        ?>

        <form action="subir.php" method="post">
            <input name="titulo" class="form-control form-control-lg" placeholder="Título"><br>
            <input name="descripcion" class="form-control form-control-lg" placeholder="Descripción"><br>
            <input name="anio" type="number" class="form-control form-control-lg" placeholder="Año"><br>
            <input name="comision" type="number" class="form-control form-control-lg" placeholder="Comisión"><br>
            <input type="submit" value="Subir anuncio" class="btn btn-primary">
        </form>
      </div>
    </body>
</html>


<!-- <form action="subir.php" method="post">
            <label for="titulo">Título</label>
            <input name="titulo" class="form-control form-control-lg"><br>
            <label for="titulo">Descripción</label>
            <input name="descripcion" class="form-control form-control-lg"><br>
            <label for="año">Año</label>
            <select name="años" class="form-control form-control-lg">
               <option value="1">1</option>
               <option value="2">2</option>
               <option value="3">3</option>
            </select><br>   
            <label for="comision">Comisión</label>
            <select name="comisiones" class="form-control form-control-lg">
               <option value="1">1</option>
               <option value="2">2</option>
               <option value="3">3</option>
            </select><br>
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" class="form-control form-control-lg" value=""><br>
            <input type="submit" value="Subir anuncio" class="btn btn-primary">
        </form> -->