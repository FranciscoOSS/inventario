<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
 
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  

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
    <!-- Modal -->
<div class="modal fade" id="myModal_actualizar" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateModalLabel">Actualizar Objeto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="mantenedor_objetos.php" method="post">
          <div class="form-group">
            <label for="objeto_modal">Objeto:</label>
            <input type="text" class="form-control" id="objeto_modal" name="objeto" required>
          </div>
          <div class="form-group">
            <label for="marca_modal">Marca:</label>
            <input type="text" class="form-control" id="marca_modal" name="marca" required>
          </div>
          <div class="form-group">
            <label for="proveedor_modal">Proveedor:</label>
            <input type="text" class="form-control" id="proveedor_modal" name="proveedor" required>
          </div>
          <div class="form-group">
            <label for="modelo_modal">Modelo:</label>
            <input type="text" class="form-control" id="modelo_modal" name="modelo" required>
          </div>
          <div class="form-group">
            <label for="localizacion_modal">Localización:</label>
            <input type="text" class="form-control" id="localizacion_modal" name="localizacion" required>
          </div>
          <input type="text" id="consulta_modal" name="consulta" value="actualizar" hidden>
          <input type="text" id="id_modal" name="id" hidden>
          <button type="submit" class="btn btn-success ">Actualizar</button>
        </form>
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
                <td> <form id='form_actualizar' action='mantenedor_objetos.php' method='post'>
                <input type='text' name='id' id='idnv' value='" . $row["id"] . "' hidden>
                <input type='text' name='consulta' value='consulta_actualizar' hidden>
                <button type='button' class='btn btn-primary btn-actualizar' data-toggle='modal' data-target='#myModal_actualizar' data-id='" . $row["id"] . " ' data-objeto='". $row["objeto"] ."' data-id='" . $row["id"] . " ' data-marca='" . $row["marca"] . " ' data-proveedor='" . $row["proveedor"] . " ' data-modelo='" . $row["modelo"] . " ' data-localizacion='" . $row["localizacion"] . " '  >Actualizar</button>
            </form>
                </td>

                <td>  <form action='mantenedor_objetos.php' method='post'>
                <input type='text'  name='id' value='" . $row["id"] . "' hidden>
                <input type='text' id='consulta' name='consulta' value='eliminar' hidden> 
                <button type='submit' class='btn btn-primary')>Eliminar</button>
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
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="functions.js"></script>
<script>$(document).ready(function () {
  // Cuando se haga clic en el botón de actualización en la tabla
  $(".btn-actualizar").click(function () {
    var idajax = $(this).data('id');
    var objetoajax =$(this).data('objeto');
    var marcaajax =$(this).data('marca');
    var proveedorajax =$(this).data('proveedor');
    var modeloajax =$(this).data('modelo');
    
    var localizacionajax =$(this).data('localizacion')

   

        $('#objeto_modal').val(objetoajax);
        $('#marca_modal').val(marcaajax);
        $('#proveedor_modal').val(proveedorajax);
        $('#modelo_modal').val(modeloajax);
        $('#localizacion_modal').val(localizacionajax);
       

    // Obtener el ID del objeto de la fila de la tabla
    
    // Asignar el ID al campo de ID del modal
    $("#idnv").val(idajax);
    // Asignar el ID al campo de ID del modal
    $("#id_modal").val(idajax);

    // Enviar el formulario a través de AJAX
    $.ajax({
      type: 'POST',
      url: 'mantenedor_objetos.php',
      data: $('#form_actualizar').serialize(), // Serializar el formulario
      success: function (response) {
        // Manejar la respuesta del servidor aquí si es necesario
        
      }

    });

   
  });
  
})</script>
  
</body>

</html>