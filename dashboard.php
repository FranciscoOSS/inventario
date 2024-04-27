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

    <!-- modal pa agregar -->
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
            <form action="mantenedor_objetos.php" method="post">
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
              <input type="text" id="consulta" name="consulta" value="agregar" hidden>
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

    <!-- modal pa actualizar -->
    <!-- Modal para actualizar objetos -->
    <div class="modal" id="myModal_actualizar">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Cabecera del Modal -->
          <div class="modal-header">
            <h4 class="modal-title">Actualizar Objeto</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Contenido del Modal -->
          <div class="modal-body">
          <?php
          require 'db.php';
          $sql = "SELECT * FROM objetos where id=?";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("s", $id);
          $stmt->execute();
          $result = $stmt->get_result();
         
          
          // Verificar si la consulta devolvió resultados
          if ($result->num_rows > 0) {
            // output data of each row

          } else {
            echo "0 results";
          }
          $conn->close();
          ?>
          ?>
          </div>
          <!-- Pie del Modal -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>







    <div class="tabla" id="tabla">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Agregar Objeto</button>
      <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Buscar por objeto">
      <?php
      require 'db.php';

      $conn = new mysqli($servername, $username, $password, $dbname);

      $sql = "SELECT objeto, marca, proveedor, modelo, localizacion, id FROM objetos ORDER BY id DESC";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->get_result();
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
                    <th>Acciones</th>
                   
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
                <td> <form action='mantenedor_objetos.php' method='post'>
                <input type='text' id='id' name='id' value='" . $row["id"] . "' hidden>
                <input type='text' id='consulta' name='consulta' value='consulta_actualizar' hidden>
                <button type='submit' class='btn btn-primary' data-toggle='modal' data-target='#myModal_actualizar'>Actualizar</button>
                </form>
                </td>

                <td>  <form action='mantenedor_objetos.php' method='post'>
                <input type='text' id='id' name='id' value='" . $row["id"] . "' hidden>
                <input type='text' id='consulta' name='consulta' value='eliminar' hidden>
                <button type='submit' class='btn btn-primary'>Eliminar</button>
                </form>
                 </td>
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


  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="functions.js"></script>
</body>

</html>