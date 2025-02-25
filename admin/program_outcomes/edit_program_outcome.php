<?php
require_once('../../config.php');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_GET['po_id'])){
    $po_id = $_GET['po_id'];
    $outcome = $conn->query("SELECT * FROM program_outcomes WHERE po_id = '$po_id'")->fetch_assoc();
    $igo_ids = $conn->query("SELECT igo_id FROM program_outcomes_igo WHERE po_id = '$po_id'")->fetch_all(MYSQLI_ASSOC);
    $cpo_ids = $conn->query("SELECT cpo_id FROM program_outcomes_cpo WHERE po_id = '$po_id'")->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Program Outcome</title>
  <?php require_once('../inc/header.php') ?>
</head>
<body>
  <div class="container-fluid">
    <form id="edit-outcome-form" method="POST" action="update_program_outcome.php">
      <input type="hidden" name="po_id" value="<?php echo $po_id; ?>">
      <div class="form-group">
        <label for="po_code">PO/GO CODE</label>
        <input type="text" class="form-control" id="po_code" name="po_code" value="<?php echo $outcome['po_code']; ?>" required>
      </div>
      <div class="form-group">
        <label for="graduate_attribute">Graduate Attribute</label>
        <select class="form-control select2" id="graduate_attribute" name="graduate_attribute" required>
          <option value="">Select Graduate Attribute</option>
          <?php
          $attributes = $conn->query("SELECT * FROM graduate_attributes ORDER BY attribute_name ASC");
          while($row = $attributes->fetch_assoc()):
          ?>
            <option value="<?php echo $row['attribute_id'] ?>" <?php echo $row['attribute_id'] == $outcome['graduate_attribute_id'] ? 'selected' : ''; ?>><?php echo $row['attribute_name'] ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="form-group">
        <label for="description">PROGRAM/GRADUATE OUTCOMES</label>
        <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $outcome['description']; ?></textarea>
      </div>
      <div class="form-group">
        <label for="igo">Institutional Graduate Outcomes (IGO)</label>
        <select class="form-control select2" id="igo" name="igo[]" multiple="multiple" required>
          <option value="">Select IGO</option>
          <?php
          $igos = $conn->query("SELECT igo_id AS id, CONCAT(igo_code, ' - ', description) AS igo_description FROM igo");
          while($row = $igos->fetch_assoc()):
          ?>
            <option value="<?php echo $row['id'] ?>" <?php echo in_array(['igo_id' => $row['id']], $igo_ids) ? 'selected' : ''; ?>><?php echo $row['igo_description'] ?></option>
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
            <option value="<?php echo $row['id'] ?>" <?php echo in_array(['cpo_id' => $row['id']], $cpo_ids) ? 'selected' : ''; ?>><?php echo $row['cpo_description'] ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="form-group">
        <label for="performance_indicator">Performance Indicator</label>
        <textarea class="form-control" id="performance_indicator" name="performance_indicator" rows="3" required><?php echo $outcome['performance_indicator']; ?></textarea>
      </div>
      <div class="form-group">
        <label for="course_id">Program</label>
        <select class="form-control" id="course_id" name="course_id" required>
          <option value="">Select Program</option>
          <?php
          $programs = $conn->query("SELECT * FROM program_list ORDER BY name ASC");
          while($row = $programs->fetch_assoc()):
          ?>
            <option value="<?php echo $row['id'] ?>" <?php echo $row['id'] == $outcome['program_id'] ? 'selected' : ''; ?>><?php echo $row['name'] ?></option>
          <?php endwhile; ?>
        </select>
      </div>
    </form>
  </div>
  <?php require_once('../inc/footer.php') ?>
  <script>
    $(document).ready(function() {
        $('.select2').select2();

        $('#edit-outcome-form').submit(function(e) {
            e.preventDefault();
            var _this = $(this);
            $.ajax({
                url: _base_url_ + 'admin/program_outcomes/update_program_outcome.php',
                method: 'POST',
                data: _this.serialize(),
                dataType: 'json',
                success: function(resp) {
                    if (resp.status == 'success') {
                        alert_toast("Program Outcome updated successfully", 'success');
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        alert_toast(resp.message, 'error');
                    }
                },
                error: function(err) {
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                }
            });
        });

        // Show only the codes after selection
        $('#igo').on('select2:select', function(e) {
            var selected = $(this).find(':selected').map(function() {
                return $(this).text().split(' - ')[0];
            }).get().join(', ');
            $(this).next('.select2-container').find('.select2-selection__rendered').text(selected);
        });

        $('#cpo').on('select2:select', function(e) {
            var selected = $(this).find(':selected').map(function() {
                return $(this).text().split(' - ')[0];
            }).get().join(', ');
            $(this).next('.select2-container').find('.select2-selection__rendered').text(selected);
        });
    });
  </script>
</body>
</html>
