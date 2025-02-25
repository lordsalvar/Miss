<?php
require_once('../config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Enroll Student</title>
  <?php require_once('../inc/header.php') ?>
</head>
<body>
  <div class="container-fluid">
    <div class="card card-outline card-primary shadow rounded-0">
      <div class="card-header">
        <h3 class="card-title">Enroll New Student</h3>
      </div>
      <div class="card-body">
        <form action="" method="POST" id="enroll_form">
          <div class="form-group">
            <label for="student_id">Student ID</label>
            <input type="text" class="form-control" id="student_id" name="student_id" required>
          </div>
          <div class="form-group">
            <label for="program">Program</label>
            <select class="form-control" id="program" name="program" required>
              <option value="">Select Program</option>
              <?php
              $programs = $conn->query("SELECT * FROM program_list ORDER BY name ASC");
              while($row = $programs->fetch_assoc()):
              ?>
                <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
              <?php endwhile; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="year_level">Year Level</label>
            <select class="form-control" id="year_level" name="year_level" required>
              <option value="1">1st Year</option>
              <option value="2">2nd Year</option>
              <option value="3">3rd Year</option>
              <option value="4">4th Year</option>
              <option value="5">5th Year</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Enroll Student</button>
        </form>
      </div>
    </div>
  </div>
  <?php require_once('../inc/footer.php') ?>
</body>
<script>
$(document).ready(function(){
  $('#enroll_form').submit(function(e){
    e.preventDefault();
    $.ajax({
      url: '<?php echo base_url ?>admin/students/save_enrollment.php',
      method: 'POST',
      data: $(this).serialize(),
      success: function(response){
        if(response == 'success'){
          alert('Student enrolled successfully');
          location.href = '<?php echo base_url ?>admin/?page=students';
        } else {
          alert('An error occurred');
        }
      }
    });
  });
});
</script>
</html>
