<?php
    include ('config.php');
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <?php require_once "menu.php" ?>
    <title>USUARIOS</title>
</head>

<body>
    <?php
    
    if(isset($_POST['actualizar'])){
    ///////////// Informacion enviada por el formulario /////////////
    $id=trim($_POST['id']);
    $nombre=trim($_POST['nombre']);
    $direccion=trim($_POST['direccion']);
    $telefono=trim($_POST['telefono']);
    $dui=trim($_POST['dui']);
    ///////// Fin informacion enviada por el formulario /// 
    
    ////////////// Actualizar la tabla /////////
    $consulta = "UPDATE clientes
    SET `nombre`= :nombre, `direccion` = :direccion, `telefono` = :telefono, `dui` = :dui
    WHERE `id` = :id";
    $sql = $conn->prepare($consulta);
    $sql->bindParam(':nombre',$nombre,PDO::PARAM_STR, 50);
    $sql->bindParam(':direccion',$direccion,PDO::PARAM_STR);
    $sql->bindParam(':telefono',$telefono,PDO::PARAM_STR, 15);
    $sql->bindParam(':dui',$dui,PDO::PARAM_STR, 10);
    $sql->bindParam(':id',$id,PDO::PARAM_INT);
    
    $sql->execute();
    
    if($sql->rowCount() > 0)
    {
    $count = $sql -> rowCount();
    echo "<div class='content alert alert-primary' > 
    
      
    Gracias: $count registro ha sido actualizado  </div>";
    }
    else{
        echo "<div class='content alert alert-danger'> No se pudo actulizar el registro  </div>";
    
    print_r($sql->errorInfo()); 
    }
    }// Cierra envio de guardado
    ?>

    <?php
    
    if(isset($_POST['eliminar'])){
    
    ////////////// Actualizar la tabla /////////
    $consulta = "DELETE FROM clientes WHERE id=:id";
    $sql = $conn-> prepare($consulta);
    $sql -> bindParam(':id', $id, PDO::PARAM_INT);
    $id=trim($_POST['id']);
    
    $sql->execute();
    
    if($sql->rowCount() > 0)
    {
    $count = $sql -> rowCount();
    echo "<div class='content alert alert-primary' > 
    Gracias: $count registro ha sido eliminado  </div>";
    }
    else{
        echo "<div class='content alert alert-danger'> No se pudo eliminar el registro  </div>";
    
    print_r($sql->errorInfo()); 
    }
    }// Cierra envio de guardado
    ?>
    <?php 
        if (isset($_POST['editar'])){
            $id = $_POST['id'];
            $sql= "SELECT * FROM clientes WHERE id = :id"; 
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
            $stmt->execute();
            $obj = $stmt->fetchObject();
    
    ?>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                    <input value="<?php echo $obj->id;?>" name="id" type="hidden">
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Nombre:</label>
                            <input type="text" value="<?php echo $obj->nombre;?>" class="form-control" id="nombre">
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Direccion:</label>
                            <input type="text" value="<?php echo $obj->direccion;?>" class="form-control" id="direccion">
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Telefono:</label>
                            <input type="text" value="<?php echo $obj->telefono;?>" class="form-control" id="telefono">
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Dui:</label>
                            <input type="text" value="<?php echo $obj->dui;?>" class="form-control" id="dui">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
    <?php
        }
    ?>

    <div class="container">
        <br>
        <div class="row justify-content-center">
            <div class="col-12 p-5 bg-white shadow-lg rounded">
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Direccion</th>
                                <th scope="col">Telefono</th>
                                <th scope="col">Dui</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $sql = "SELECT * FROM clientes";
                            $query = $conn -> prepare($sql);
                            $query -> execute();
                            $Resultado = $query -> fetchAll(PDO::FETCH_OBJ);

                            if($query -> rowCount() > 0)
                            {
                                foreach($Resultado as $Fila)
                                {
                                    echo"<tr>
                                            <td>".$Fila -> Id."</td>
                                            <th>".$Fila -> Nombre."</th>
                                            <td>".$Fila -> Direccion."</td>
                                            <td>".$Fila -> Telefono."</td>
                                            <td>".$Fila -> Dui."</td>
                                        <td>
                                            <form method='POST' action='".$_SERVER['PHP_SELF']."'>
                                                <input type='hidden' name='id' value='".$Fila -> Id."'>
                                                <button name='editar' type='button' data-bs-toggle='modal' data-bs-target='#exampleModal' data-bs-whatever='@mdo' class='btn btn-warning'>Editar</button>
                                            </form>
                                        </td>

                                        <td>
                                            <form  onsubmit=\"return confirm('Realmente desea eliminar el registro?');\" method='POST' action='".$_SERVER['PHP_SELF']."'>
                                                <input type='hidden' name='id' value='".$Fila -> Id."'>
                                                <button name='eliminar' class='btn btn-danger'>Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>";
                                }
                            }
                        ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>