<?php
require_once('../config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Enrolled Students</title>
  <?php require_once('../inc/header.php') ?>
</head>
<body>
  <div class="container-fluid">
    <div class="card card-outline card-primary shadow rounded-0">
      <div class="card-header">
        <h3 class="card-title">List of Enrolled Students</h3>
      </div>
      <div class="card-body">
        <table class="table table-bordered table-hover table-striped">
          <colgroup>
            <col width="5%">
            <col width="20%">
            <col width="20%">
            <col width="25%">
            <col width="15%">
          </colgroup>
          <thead>
            <tr class="bg-gradient-dark text-light">
              <th>#</th>
              <th>Student ID</th>
              <th>Name</th>
              <th>Program</th>
              <th>Year Level</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              $i = 1;
              $qry = $conn->query("SELECT e.*, s.roll, CONCAT(s.lastname, ', ', s.firstname, ' ', s.middlename) AS fullname, p.name AS program FROM enrollments e INNER JOIN student_list s ON e.student_id = s.id INNER JOIN program_list p ON e.program_id = p.id ORDER BY e.date_created DESC");
              while($row = $qry->fetch_assoc()):
            ?>
              <tr>
                <td class="text-center"><?php echo $i++; ?></td>
                <td><?php echo $row['roll'] ?></td>
                <td><?php echo $row['fullname'] ?></td>
                <td><?php echo $row['program'] ?></td>
                <td><?php echo $row['year_level'] ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <?php require_once('../inc/footer.php') ?>
</body>
<script>
$(document).ready(function(){
  $('.table').dataTable({
    columnDefs: [
      { orderable: false, targets: 4 }
    ],
  });
});
</script>
</html>
