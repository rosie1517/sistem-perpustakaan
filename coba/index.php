<?php
include('./template/head.php');
include('./config/database_connection.php');

function getAllUser($db)
{
    $sql = "SELECT * FROM registrasi";
    return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

?>
<div class="container py-4">
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama</th>
          <th>Tanggal Lahir</th>
          <th>Username</th>
          <th>Password</th>
          <th>No HP</th>
        </tr>
      </thead>
      <tbody>
        <?php if (getAllUser($db)) : ?>
        <?php foreach (getAllUser($db) as $registrasi) : ?>
        <tr>
          <td><?= $registrasi['Id'] ?></td>
          <td><?= $registrasi['nama'] ?></td>
          <td><?= $registrasi['tanggallahir'] ?></td>
          <td><?= $registrasi['username'] ?></td>
          <td><?= $registrasi['password'] ?></td>
          <td><?= $registrasi['no_hp'] ?></td>
          <td>
            <a
              href="./update_user.php?Id=<?= $registrasi['Id'] ?>"
              class="btn btn-sm btn-success"
              >Update</a
            >
            <a
              href="./delete_user.php?Id=<?= $registrasi['Id'] ?>"
              class="btn btn-sm btn-danger"
              >Delete</a
            >
          </td>
        </tr>
        <?php endforeach; ?>
        <?php else : ?>
        <tr>
          <td colspan="5" class="text-center">Tidak ada data</td>
        </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php
include('./template/foot.php');
?>