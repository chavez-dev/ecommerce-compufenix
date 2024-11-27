<?php include("../../include/cabecera.php"); ?>
    
    <title>Recibos - Compufenix</title>
    <link rel="stylesheet" href="../../css/admin/tienda.css">

<?php include("../../include/sidebar.php"); ?>

<?php 
include("../../../backend/config/conexion.php");

// Obtener los datos de la tienda (suponiendo que solo hay una tienda, con id_tienda = 1)
$stmt = $conexion->prepare("SELECT * FROM tienda WHERE id_tienda = 1");
$stmt->execute();
$tienda = $stmt->fetch(PDO::FETCH_ASSOC);

// Si no se encuentran datos de la tienda
if (!$tienda) {
    echo "<p>No se encontraron datos de la tienda.</p>";
    exit;
}
?>

<style>
  .form-control {
    border-color: #ced4da; /* Gris más oscuro (puedes ajustar este valor) */
  }
</style>

        <!-- CONTENIDO PRINCIPAL -->
        <main class="main-principal container">
            <h2 class="mb-4">Datos de la Tienda</h2>
            <form id="form_tienda">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="razon_social">Razón Social:</label>
                        <input type="text" class="form-control border-dark-subtle" id="razon_social" value="<?php echo $tienda['razon_social']; ?>" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="ruc">RUC:</label>
                        <input type="text" class="form-control border-dark-subtle" id="ruc" value="<?php echo $tienda['ruc']; ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="direccion">Dirección:</label>
                        <input class="form-control border-dark-subtle" id="direccion" value="<?php echo $tienda['direccion']; ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="correo">Correo:</label>
                        <input type="email" class="form-control border-dark-subtle" id="correo" value="<?php echo $tienda['correo']; ?>" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="telefono_1">Teléfono 1:</label>
                        <input type="text" class="form-control border-dark-subtle" id="telefono_1" value="<?php echo $tienda['telefono_1']; ?>" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="telefono_2">Teléfono 2:</label>
                        <input type="text" class="form-control border-dark-subtle" id="telefono_2" value="<?php echo $tienda['telefono_2']; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="departamento">Departamento:</label>
                        <input type="text" class="form-control border-dark-subtle" id="departamento" value="<?php echo $tienda['departamento']; ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="provincia">Provincia:</label>
                        <input type="text" class="form-control border-dark-subtle" id="provincia" value="<?php echo $tienda['provincia']; ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="distrito">Distrito:</label>
                        <input type="text" class="form-control border-dark-subtle" id="distrito" value="<?php echo $tienda['distrito']; ?>">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Guardar Cambios</button>
            </form>
        </main>
        <!-- CONTENIDO PRINCIPAL -->

        <script>
            $(document).ready(function() {
                $('#form_tienda').submit(function(e) {
                    e.preventDefault(); // Prevenir el comportamiento por defecto del formulario
                    
                    var formData = {
                        razon_social: $('#razon_social').val(),
                        ruc: $('#ruc').val(),
                        direccion: $('#direccion').val(),
                        correo: $('#correo').val(),
                        telefono_1: $('#telefono_1').val(),
                        telefono_2: $('#telefono_2').val(),
                        departamento: $('#departamento').val(),
                        provincia: $('#provincia').val(),
                        distrito: $('#distrito').val()
                    };
                    
                    $.ajax({
                        url: '../../../backend/consultas/editar_tienda.php', // Archivo PHP que procesa la actualización
                        method: 'POST',
                        data: formData,
                        success: function(response) {
                            var data = JSON.parse(response);
                            if (data.status == 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: data.message,
                                    showConfirmButton: true
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'No se pudo actualizar los datos.'
                                });
                            }
                        }
                    });
                });
            });

        </script>

<?php include("../../include/footer.php"); ?>