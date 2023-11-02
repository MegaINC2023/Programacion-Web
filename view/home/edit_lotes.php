<?php
include("config\usersDB.php");
$estado= '';
$peso= '';
$almacen_destino= '';

if  (isset($_GET['id_lote'])) {
  $id_lote = $_GET['id_lote'];
  $query = "SELECT * FROM lote WHERE id_lote=$id_lote";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result);
    $id_lote = $row['id_lote'];
    $estado = $row['estado'];
    $peso = $row['peso'];
    $almacen_destino = $row['almacen_destino'];
  }
}

if (isset($_POST['update'])) {
  $id_lote = $_POST['id_lote'];
  $estado= $_POST['estado'];
  $peso = $_POST['peso'];
  $almacen_destino = $_POST['almacen_destino'];

  $query = "UPDATE lote set estado = '$estado', peso = '$peso', almacen_destino = '$almacen_destino'  WHERE id_lote=$id_lote";
  mysqli_query($conn, $query);
  $_SESSION['message'] = 'Se modifico correctamente';
  $_SESSION['message_type'] = 'warning';
  header('Location: gestionLotes.php');
}

?>
<?php include('includes\header.php'); ?>
<div class="container p-4">
  <div class="row">
    <div class="col-md-4 mx-auto">
      <div class="card card-body">
      <form action="edit_lotes.php" method="POST">
      <input type="hidden" name="id_lote" value="<?php echo $id_lote; ?>">
        <div class="form-group">
          <input name="estado" type="text" class="form-control" value="<?php echo $estado; ?>" placeholder="cambiar estado">
        </div>
        <div class="form-group">
          <input name="peso" type="text" class="form-control" value="<?php echo $peso; ?>" placeholder="cambiar peso">
        </div>
        <div class="form-group">
          <input name="almacen_destino" type="text" class="form-control" value="<?php echo $almacen_destino; ?>" placeholder="cambiar el destino">
        </div>
        <button class="btn-success" name="update">
          Cambiar
</button>
      </form>
      </div>
    </div>
  </div>
</div>
<div class="col-md-4 mx-auto">
        <form action="save_asignar.php" method="POST">
          <div class="form-group">
            <input type="text" name="id_paquete" class="form-control" placeholder="Id paquete" autofocus>
          </div>
          <input type="hidden" name="id_lote" value="<?php echo $id_lote; ?>">
          <input type="submit" name="save_asignar" class="btn btn-success btn-block" value="Asignar a lote">
        </form>
      </div>
      <div class="col-md-4 mx-auto">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Id lote</th>
            <th>Id paquete</th>
            <th>Eliminar</th>
          </tr>
        </thead>
        <tbody>

          <?php
          $queryp = "SELECT id_paquete FROM pertenece WHERE id_lote = $id_lote";
          $result_tasks = mysqli_query($conn, $queryp);    

          while ($row = mysqli_fetch_assoc($result_tasks)) {
            ?>
            <tr>
                <td><?php echo $id_lote; ?></td> <!-- Muestra el id_lote -->
                <td><?php echo $row['id_paquete']; ?></td> <!-- Muestra el id_paquete -->
                <td>
                    <a href="delete_asignar.php?id_paquete=<?php echo $row['id_paquete']; ?>" class="btn btn-danger">
                        <i class="far fa-trash-alt"></i>
                    </a>
                </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

<?php
// Mostrar tabla de dirección
$queryDireccion = "SELECT D.id_paquete, D.localidad, L.departamento
FROM Direccion AS D
INNER JOIN Localidad AS L ON D.localidad = L.localidad
WHERE D.id_paquete NOT IN (SELECT id_paquete FROM pertenece);";
$resultDireccion = mysqli_query($conn, $queryDireccion);
?>
<div>
  <h2>Paquetes</h2>
  <table>
    <thead>
      <tr>
        <th>ID Paquete</th>
        <th>Localidad</th>
        <th>Departamento</th>
      </tr>
    </thead>
    <tbody>
      <?php
      while ($row = mysqli_fetch_assoc($resultDireccion)) {
        ?>
        <tr>
          <td><?php echo $row['id_paquete']; ?></td>
          <td><?php echo $row['localidad']; ?></td>
          <td><?php echo $row['departamento']; ?></td>
        </tr>
        <?php
      }
      ?>
    </tbody>
  </table>
</div>
<?php include('includes\footer.php'); ?>
