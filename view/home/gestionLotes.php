<?php include("config\usersDB.php"); ?>

<?php include('includes\header.php'); ?>

<main class="container p-4">
  <div class="row">
    <div class="col-md-4">
      <!-- MESSAGES -->

      <?php if (isset($_SESSION['message'])) { ?>
      <div class="alert alert-<?= $_SESSION['message_type']?> alert-dismissible fade show" role="alert">
        <?= $_SESSION['message']?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php session_unset(); } ?>

      <!-- ADD TASK FORM -->
      <div class="card card-body">
        <form action="save_lotes.php" method="POST">
          <div class="form-group">
            <input type="text" name="estado" class="form-control" placeholder="ingresar estado del lote" autofocus required>
          </div>
          <div class="form-group">
            <input type="text" name="peso" class="form-control" placeholder="ingresar el peso del lote" autofocus required>
          </div>
          <div class="form-group">
            <input type="text" name="almacen_destino" class="form-control" placeholder="id del almacen destino" autofocus required>
          </div>
          
          <input type="submit" name="save_lotes" class="btn btn-success btn-block" value="Guardar">
        </form>
      </div>
    </div>
    <div class="col-md-8">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Id lote</th>
            <th>Estado</th>
            <th>Peso</th>
            <th>Almacen Destino</th>
            <th>Opciones</th>
          </tr>
        </thead>
        <tbody>

          <?php
          $query = "SELECT * FROM lote";
          $result_tasks = mysqli_query($conn, $query);    

          while($row = mysqli_fetch_assoc($result_tasks)) { ?>
          <tr>
            <td><?php echo $row['id_lote']; ?></td>
            <td><?php echo $row['estado']; ?></td>
            <td><?php echo $row['peso']; ?></td>
            <td><?php echo $row['almacen_destino']; ?></td>
            <td>
              <a href="edit_lotes.php?id_lote=<?php echo $row['id_lote']?>" class="btn btn-secondary">
                <i class="fas fa-marker"></i>
              </a>
              <a href="delete_lotes.php?id_lote=<?php echo $row['id_lote']?>" class="btn btn-danger">
                <i class="far fa-trash-alt"></i>
              </a>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</main>

