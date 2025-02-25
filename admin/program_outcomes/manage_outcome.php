<?php
require_once('../../config.php');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add New Program Outcomes</title>
  <?php require_once('../inc/header.php') ?>
</head>
<body>  
  <div class="container-fluid">
    <form id="manage-outcome-form" method="POST" action="save_program_outcome.php">
      <div class="form-group">
        <label for="po_code">PO/GO CODE</label>
        <input type="text" class="form-control" id="po_code" name="po_code" required>
      </div>
      <div class="form-group">
        <label for="graduate_attribute">Graduate Attribute</label>
        <select class="form-control select2" id="graduate_attribute" name="graduate_attribute" required>
          <option value="">Select Graduate Attribute</option>
          <?php
          $attributes = $conn->query("SELECT * FROM graduate_attributes ORDER BY attribute_name ASC");
          while($row = $attributes->fetch_assoc()):
          ?>
            <option value="<?php echo $row['attribute_id'] ?>"><?php echo $row['attribute_name'] ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="form-group">
        <label for="description">PROGRAM/GRADUATE OUTCOMES</label>
        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
      </div>
      <div class="form-group">
        <label for="igo">Institutional Graduate Outcomes (IGO)</label>
        <select class="form-control select2" id="igo" name="igo[]" multiple="multiple" required>
          <option value="">Select IGO</option>
          <?php
          $igos = $conn->query("SELECT igo_id AS id, CONCAT(igo_code, ' - ', description) AS igo_description FROM igo");
          while($row = $igos->fetch_assoc()):
          ?>
            <option value="<?php echo $row['id'] ?>"><?php echo $row['igo_description'] ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="form-group">
        <label for="cpo">Common Program Outcomes (CPO)</label>
        <select class="form-control select2" id="cpo" name="cpo[]" multiple="multiple" required>
          <option value="">Select CPO</option>
          <?php
          $cpos = $conn->query("SELECT cpo_id AS id, CONCAT(cpo_code, ' - ', description) AS cpo_description FROM cpo");
          while($row = $cpos->fetch_assoc()):
          ?>
            <option value="<?php echo $row['id'] ?>"><?php echo $row['cpo_description'] ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="form-group">
        <label for="performance_indicator">Performance Indicator</label>
        <textarea class="form-control" id="performance_indicator" name="performance_indicator" rows="3" required></textarea>
      </div>
      <div class="form-group">
        <label for="course_id">Program</label>
        <select class="form-control" id="course_id" name="course_id" required>
          <option value="">Select Program</option>
          <?php
          $programs = $conn->query("SELECT * FROM program_list ORDER BY name ASC");
          while($row = $programs->fetch_assoc()):
          ?>
            <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="form-group text-right">
        <button class="btn btn-flat btn-primary btn-sm" type="submit">Save Program Outcome</button>
      </div>
    </form>
  </div>
  <?php require_once('../inc/footer.php') ?>
  <script>
$(document).ready(function() {
    $('.select2').select2();

    $('#manage-outcome-form').submit(function(e) {
        e.preventDefault();
        var _this = $(this);
        
        $.ajax({
            url: _base_url_ + 'admin/program_outcomes/save_program_outcome.php',
            method: 'POST',
            data: _this.serialize(),
            dataType: 'json',
            success: function(resp) {
                if (resp.status === 'success') {
                    alert_toast("Program Outcome added successfully", 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    alert_toast(resp.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                alert_toast("An error occurred: " + xhr.responseText, 'error');
            }
        });
    });
});
  </script>
</body>
</html>
