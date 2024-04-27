<?php
    require 'db.php';
    // Verificar si se reciben datos del formulario
    $consulta=$_POST['consulta'];
if ($_SERVER["REQUEST_METHOD"] == "POST" and $consulta=="agregar") {
    // Recibir y sanitizar los datos del formulario
    $objeto = htmlspecialchars($_POST["objeto"]);
    $marca = htmlspecialchars($_POST["marca"]);
    $proveedor = htmlspecialchars($_POST["proveedor"]);
    $modelo = htmlspecialchars($_POST["modelo"]);
    $localizacion = htmlspecialchars($_POST["localizacion"]);


    $sql = "INSERT INTO objetos (objeto, marca, proveedor, modelo, localizacion) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Vincular parámetros y ejecutar la consulta
    $stmt->bind_param("sssss", $objeto, $marca, $proveedor, $modelo, $localizacion);

    if ($stmt->execute()) {
        echo "Objeto agregado exitosamente.";
        header("Location: dashboard.php");
    } else {
        echo "Error al agregar objeto: " . $stmt->error;
    }

    // Cerrar la conexión y liberar recursos
    $stmt->close();
    $conn->close();
} 

if ($_SERVER["REQUEST_METHOD"] == "POST" and $consulta=="eliminar") {
    $id = $_POST["id"];
    $sql = "delete from objetos where id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    try{
        $stmt->execute();
    } catch (Exception $e) {
        echo "Error al eliminar objeto: " . $stmt->error;
    }
    finally{
        $stmt->close();
        $conn->close();
    }
    header("Location: dashboard.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" and $consulta=="consulta_actualizar") {
    $id = $_POST["id"];
    $sql = "SELECT objeto, marca, proveedor, modelo, localizacion, id from objetos where id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    try{
        $stmt->execute();
        $result = $stmt->get_result();
        $result = $result->fetch_assoc();
        $objeto=$result['objeto'];
        $marca=$result['marca'];
        $proveedor=$result['proveedor'];
        $modelo=$result['modelo'];
        $localizacion=$result['localizacion'];
        $id=$result['id'];

        echo '
        <div class="modal-body">
            <!-- Formulario para agregar objetos -->
            <form action="mantenedor_objetos.php" method="post">
              <div class="form-group">
                <label for="objeto">Objeto:</label>
                <input type="text" class="form-control" id="objeto" name="objeto" value="'. $objeto .'" required>
              </div>
              <div class="form-group">
                <label for="marca">Marca:</label>
                <input type="text" class="form-control" id="marca" name="marca" value="'. $marca .'" required>
              </div>
              <div class="form-group">
                <label for="proveedor">Proveedor:</label>
                <input type="text" class="form-control" id="proveedor" name="proveedor" value="'. $proveedor .'" required>
              </div>
              <div class="form-group">
                <label for="modelo">Modelo:</label>
                <input type="text" class="form-control" id="modelo" name="modelo" value="'. $modelo .'" required>
              </div>
              <div class="form-group">
                <label for="localizacion">Localización:</label>
                <input type="text" class="form-control" id="localizacion" name="localizacion" value="'. $localizacion .'" required>
              </div>
              <input type="text" id="consulta" name="consulta" value="actualizar" hidden>
                <input type="text" id="id" name="id" value="'. $id .'" hidden>
              <button type="submit" class="btn btn-success">Actualizar '. $objeto .'</button>
            </form>
          </div>';

    } catch (Exception $e) {
        echo "Error al eliminar objeto: " . $stmt->error;
    }
    finally{
        $stmt->close();
        $conn->close();
    }
}

// if ($_SERVER["REQUEST_METHOD"] == "POST" and $consulta=="actualizar") {
//     $id = $_POST["id"];
//     $objeto = $_POST["objeto"];
//     $marca = $_POST["marca"];
//     $proveedor = $_POST["proveedor"];
//     $modelo = $_POST["modelo"];
//     $localizacion = $_POST["localizacion"];
//     $sql = "UPDATE objetos SET objeto=?, marca=?, proveedor=?, modelo=?, localizacion=? WHERE id=?";
  
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("ssssss", $objeto, $marca, $proveedor, $modelo, $localizacion, $id);
//     try{
//         $stmt->execute();
//         echo "Objeto actualizado exitosamente.";
//     } catch (Exception $e) {
//         echo "Error al Actualizar objeto: " . $stmt->error;
        
//     }
//     finally{
//         $stmt->close();
//         $conn->close();
//     }
// }
?>