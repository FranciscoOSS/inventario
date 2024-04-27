<?php
    // Verificar si se reciben datos del formulario
    
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir y sanitizar los datos del formulario
    $objeto = htmlspecialchars($_POST["objeto"]);
    $marca = htmlspecialchars($_POST["marca"]);
    $proveedor = htmlspecialchars($_POST["proveedor"]);
    $modelo = htmlspecialchars($_POST["modelo"]);
    $localizacion = htmlspecialchars($_POST["localizacion"]);

    // Validar los datos (puedes agregar más validaciones según tus necesidades)

    // Conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "inventario";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Preparar la consulta SQL para insertar un nuevo objeto
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
} else {
    // Redirigir si se intenta acceder directamente al archivo
    header("Location: index.php");
    exit();
}
?>