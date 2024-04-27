<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventario";

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error en la conexión a la base de datos: " . $conn->connect_error);
}

// Obtener datos del formulario
$username = $_POST['username'];
$password = $_POST['password'];

// Consulta para verificar la autenticación
$sql = "SELECT * FROM usuarios WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Inicio de sesión exitoso
    header("Location: dashboard.php"); // Redirige a la página de inicio después del inicio de sesión
} else {
    // Usuario o contraseña incorrectos
    header("Location: index.php?message=Nombre de usuario o contraseña incorrectos. Inténtalo de nuevo.");
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
