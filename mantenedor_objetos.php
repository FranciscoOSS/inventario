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
        
            $(document).ready(function() {
                $("#myModal_actualizar").modal("show");
                $("#objeto_modal").val("' . $objeto . '");
                $("#marca_modal").val("' . $marca . '");
                $("#proveedor_modal").val("' . $proveedor . '");
                $("#modelo_modal").val("' . $modelo . '");
                $("#localizacion_modal").val("' . $localizacion . '");
                $("#id_modal").val("' . $id . '");
            });
        ';
        
    
      
       
        
        
        
        

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