<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <?php require_once "navbar.php" ?>
    <title>Cliente</title>
</head>

<body>
    <div class="container"><br>
        <div class="row justify-content-center">
            <div class="col-8 p-5 bg-white shadow-lg rounded">
                <?php
                include('config.php');
                session_start();
                if (isset($_POST['registro'])) {

                    $nombre = $_POST['nombre'];
                    $direccion = $_POST['direccion'];
                    $telefono = $_POST['telefono'];
                    $dui = $_POST['dui'];

                    $query = $conn->prepare("SELECT * FROM clientes WHERE telefono=:telefono OR dui=:dui");
                    $query->bindParam("telefono", $telefono, PDO::PARAM_STR);
                    $query->bindParam("dui", $dui, PDO::PARAM_STR);
                    $query->execute();

                    if ($query->rowCount() > 0) {
                        echo '
                        <div class="alert alert-danger" role="alert">
                        ¡El numero de telefono o dui ya estan registrados!
                        </div>';
                    }

                    if ($query->rowCount() == 0) {
                        $query = $conn->prepare("INSERT INTO clientes(nombre, direccion, telefono, dui) VALUES (:nombre,:direccion,:telefono,:dui)");
                        $query->bindParam("nombre", $nombre, PDO::PARAM_STR);
                        $query->bindParam("direccion", $direccion, PDO::PARAM_STR);
                        $query->bindParam("telefono", $telefono, PDO::PARAM_STR);
                        $query->bindParam("dui", $dui, PDO::PARAM_STR);
                        $result = $query->execute();

                        if ($result) {
                            echo '
                                <div class="alert alert-success" role="alert">
                                    ¡Tu registro fue exitoso!
                                </div>';
                        } else {
                            echo '
                                <div class="alert alert-danger" role="alert">
                                    ¡Algo salió mal!
                                </div>';
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>