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