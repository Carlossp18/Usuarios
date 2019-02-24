<?php
spl_autoload_register(function($clase) {
    require "$clase.php";
});
$name = "";
$pass = "";
if (isset($_POST['submit'])) {
    $bd = new BBDD();
    $name = $_POST['user'];
    $name1 = $bd->getConexion()->real_escape_string($name);
    $pass = $_POST['pass'];
    //$pass1 = $bd->getConexion()->real_escape_string($pass);
    $passC = md5($pass);

    switch ($_POST['submit']) {
        case 'insertar':
            if ($bd->checkState()) {
                echo $bd->existeValue("name", $name1, "usuarios", "name");
                if (!$bd->existeValue("name", $name1, "usuarios", "name")) {
                    $correcto = $bd->modifyQuery("insert into usuarios values ('$name1', '$passC')");
                    ($correcto) ? "Usuario insertado correctamente" : "Se ha producido un error";
                } else {
                    $msj = "Se ha producido un error. Intentelo más tarde.";
                }
            } else {
                echo $bd;
            }
            break;
        case 'acceder':
            if ($bd->existeValue("*", $name1, "usuarios", "name", "AND password='$passC'")) {
                session_start();
                $_SESSION['user'] = $name1;
                header("Location:welcome.php");
            } else {
                $msj = "CREDENCIALES INCORRECTAS";
            }
            break;
    }
    $bd->cerrarConexion();
}

function mostrarTabla() {
    echo "<table>";
    echo "<tr>";
    $bd = new BBDD();
    $campos = $bd->nombresCampos("usuarios");
    foreach ($campos as $campo) {
        echo"<th>$campo</th>";
    }
    echo "</tr>";
    $usuarios = $bd->selectQuery("select * from usuarios");
    foreach ($usuarios as $usuario) {
        echo"<tr>";
        foreach ($usuario as $cam) {
            echo"<td>$cam</td>";
        }
        echo"</tr>";
    }
    echo "</table>";
    $bd->cerrarConexion();
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style>
            label{
                display: inline-block; width: 100px;margin-bottom: 10px;
            }
            table{
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 50%;
                margin: 0 auto;
                margin-top: 25px;
            }

            td, th{
                border: 1px solid #ddd;
                padding: 8px;
            }
            tr:nth-child(even){
                background-color: #f2f2f2;
            }
            tr:hover {
                background-color: #ddd;
            }
            th {
                padding-top: 12px;
                padding-bottom: 12px;
                text-align: left;
                background-color: #4CAF50;
                color: white;
            }
        </style>
    </head>
    <body>
        <h3><?php echo $msj ?></h3>
        <fieldset>
            <legend>Login</legend><br>
            <form action="index.php" method="POST">
                <input type="hidden" name="user" value="<?php echo $name ?>">
                <input type="hidden" name="pass" value="<?php echo $pass ?>">
                <label>Usuario:</label> <input type="text" name="user" placeholder="<?php echo $name
?>"><br>
                <label>Contraseña:</label> <input type="password" name="pass" placeholder="<?php echo $pass ?>"><br><br>
                <input type="submit" name="submit" value="mostrar">
                <input type="submit" name="submit" value="insertar">
                <input type="submit" name="submit" value="acceder">
            </form>
        </fieldset>
        <?php
        if (isset($_POST['submit'])) {
            if ($_POST['submit'] == "mostrar") {
                mostrarTabla();
            }
        }
        ?>
    </body>
</html>
