<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="CSS\index.css">

  <title>Dashboard with Full-height Sidebar</title>
</head>

<body>
  <!-- Side navigation -->
  <div class="sidenav">
    <img src="https://liceosanfrancisco.cl/imagen_liceo/liceo_footer.png" alt="insigniaSide" id="insigniaSide">
    <a href="dashboard.php">Objetos</a>
    <a href="#">Proveedores</a>
    <a href="#">Compras</a>
    <a href="#">Contact</a>
  </div>

  <!-- Page content -->
  <div class="main">


    <!-- Modal para agregar objetos -->
    <div class="modal" id="myModal">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Cabecera del Modal -->
          <div class="modal-header">
            <h4 class="modal-title">Agregar Objeto</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Contenido del Modal -->
          <div class="modal-body">
            <!-- Formulario para agregar objetos -->
            <form action="agregar_objeto.php" method="post">
              <div class="form-group">
                <label for="objeto">Objeto:</label>
                <input type="text" class="form-control" id="objeto" name="objeto" required>
              </div>
              <div class="form-group">
                <label for="marca">Marca:</label>
                <input type="text" class="form-control" id="marca" name="marca" required>
              </div>
              <div class="form-group">
                <label for="proveedor">Proveedor:</label>
                <input type="text" class="form-control" id="proveedor" name="proveedor" required>
              </div>
              <div class="form-group">
                <label for="modelo">Modelo:</label>
                <input type="text" class="form-control" id="modelo" name="modelo" required>
              </div>
              <div class="form-group">
                <label for="localizacion">Localización:</label>
                <input type="text" class="form-control" id="localizacion" name="localizacion" required>
              </div>
              <button type="submit" class="btn btn-success">Agregar</button>
            </form>
          </div>

          <!-- Pie del Modal -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          </div>

        </div>
      </div>
    </div>

    <div class="tabla" id="tabla">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
        Agregar Objeto
      </button>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
        Actualizar Objeto
      </button>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
        Borrar Objeto
      </button>
      
      <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Buscar por objeto">
      <?php
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "inventario";

      $conn = new mysqli($servername, $username, $password, $dbname);

      if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
      }

      $sql = "SELECT objeto, marca, proveedor, modelo, localizacion, id FROM objetos";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {

        echo "
    <table class='table table-striped'>
            <thead class='thead-light'>
                <tr>
                    <th>ID</th>
                    <th>Objeto</th>
                    <th>Marca</th>
                    <th>Proveedor</th>
                    <th>Modelo</th>
                    <th>Localización</th>
                   
                </tr>
            </thead>
            <tbody>";

        while ($row = $result->fetch_assoc()) {
          echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["objeto"] . "</td>
                <td>" . $row["marca"] . "</td>
                <td>" . $row["proveedor"] . "</td>
                <td>" . $row["modelo"] . "</td>
                <td>" . $row["localizacion"] . "</td>
                
              </tr>";
        }

        echo "</tbody></table>";
      } else {
        echo "No se encontraron resultados en la base de datos.";
      }

      $conn->close();
      ?>
    </div>
  </div>


  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    function myFunction() {
      // Declare variables
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("tabla");
      tr = table.getElementsByTagName("tr");

      // Loop through all table rows, and hide those who don't match the search query
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
  </script>
  <script>
    // AJAX para enviar datos del formulario y actualizar la tabla sin recargar la página
    $(document).ready(function () {
      $('#addForm').submit(function (e) {
        e.preventDefault();
        $.ajax({
          type: 'POST',
          url: 'agregar_objeto.php', // Ruta al archivo PHP que procesa el formulario
          data: $(this).serialize(),
          success: function (data) {
            // Actualizar la tabla después de agregar un objeto
            $('#myModal').modal('hide'); // Cerrar el modal
            location.reload(); // Recargar la página para actualizar la tabla
          }
        });
      });
    });
  </script>
</body>

</html>