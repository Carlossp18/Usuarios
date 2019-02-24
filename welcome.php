<?php
session_start();
if (isset($_SESSION['user'])) {
    $name2 = $_SESSION['user'];
} else {
    header("Location:index.php?msj=No has iniciado sesión");
}

if (isset($_POST['submit'])) {
    if ($_POST['submit'] == "(desconectar)") {
        session_destroy();
        header("Location:index.php");
        exit();
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Bienvenido</title>
        <style>
            body{
                background-color: #d7dee8;
                margin: 0;
                font-family: Verdana;
                font-size: 1.2em;
            }
            .top{
                width: 100%;
                height: 75px;
                margin-top: 0px;
                background-color: #333;
                color: azure;
                padding: 0;
                top: 0;

            }
            .logged{
                margin-left: 85%;
                padding-top: 27px;
            }
            #user{
                color:#ad47c6;
            }

            #des{
                background:none;
                border:none;
                margin:0;
                padding:0;
                cursor: pointer;
                color: #dbc6a2;
                font-size: 0.85em;
            }
            .mid{
                width: 98%;
                height: 600px;
                border-radius: 17px;
                margin: 0 auto;
                margin-top: 20px;
                background-color: activecaption;
            }

        </style>
    </head>
    <body>
        <div class="top">
            <div class="logged">
                <form action="index.php" method="POST">
                    Bienvenido,<label id="user"><?php echo " $name2" ?></label>
                    <input id="des" type="submit" name="submit" value="(desconectar)">
                </form>
            </div>
        </div>
        <div class="mid"></div>
        <div class="mid"></div>
    </body>
</html>