<?php
require_once('../../config.php');
$program_outcomes = [];
$course_id = isset($_GET['id']) ? $_GET['id'] : '';
$program_id = null;

if ($course_id) {
    // Fetch course details and program outcomes
    $course_qry = $conn->query("SELECT c.*, c.program_outcomes as po_codes, p.name as program_name, c.program_id 
                               FROM `course_list` c 
                               LEFT JOIN program_list p ON p.id = c.program_id 
                               WHERE c.id = '{$course_id}'");
    if ($course_qry->num_rows > 0) {
        $course_details = $course_qry->fetch_assoc();
        $program_id = $course_details['program_id'];
        $catalog_number = $course_details['catalog_number'];
        $course_title = $course_details['course_title'];
        // Get program outcomes from the comma-separated string
        if(!empty($course_details['po_codes'])) {
            $program_outcomes = explode(',', $course_details['po_codes']);
        }
    }
}
?>

<link rel="stylesheet" href="<?php echo base_url ?>assets/css/custom.css">

<div class="container-fluid">
    <form action="" id="programOutcomesForm">
        <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
        <input type="hidden" name="program_id" value="<?php echo $program_id; ?>">
        
        <!-- Display selected course details -->
        <?php if(isset($course_details)): ?>
        <div class="form-group">
            <label>Selected Course Details:</label>
            <div class="pl-4">
                <p><strong>Program:</strong> <?= $course_details['program_name'] ?></p>
                <p><strong>Course:</strong> <?= $course_details['catalog_number'] . ' - ' . $course_details['course_title'] ?></p>
            </div>
        </div>
        <?php endif; ?>

        <!-- Program Outcomes Table -->
        <div class="form-group">
            <label class="control-label">Program Outcomes</label>
            <div id="program_outcomes_container" class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if($program_id) {
                            $po_qry = $conn->query("SELECT po_code, description FROM program_outcomes 
                                                  WHERE program_id = '{$program_id}' 
                                                  ORDER BY po_code");
                            while($row = $po_qry->fetch_assoc()):
                                $is_checked = in_array($row['po_code'], $program_outcomes) ? 'checked' : '';
                        ?>
                        <tr data-po-code="<?= $row['po_code'] ?>">
                            <td>
                                <input class="form-check-input" type="checkbox" 
                                       name="program_outcomes[]" 
                                       value="<?= $row['po_code'] ?>" 
                                       id="outcome_<?= $row['po_code'] ?>" 
                                       <?= $is_checked ?>>
                                <label class="form-check-label" for="outcome_<?= $row['po_code'] ?>">
                                    <strong><?= htmlspecialchars($row['po_code']) ?></strong>
                                </label>
                            </td>
                            <td><?= htmlspecialchars($row['description']) ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger" onclick="deleteProgramOutcome('<?= $row['po_code'] ?>', this)">Delete</button>
                            </td>
                        </tr>
                        <?php endwhile;
                        } else { ?>
                        <tr>
                            <td colspan="3" class="text-center">No program outcomes found.</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="form-group text-right">
            <button type="submit" class="btn btn-primary">Save Program Outcomes</button>
            <a href="./?page=curriculum" class="btn btn-default">Cancel</a>
        </div>
    </form>
</div>

<script>
    function deleteProgramOutcome(po_code, button) {
        if (confirm("Are you sure you want to delete this program outcome?")) {
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=delete_program_outcome",
                method: 'POST',
                data: { po_code: po_code, course_id: $('input[name="course_id"]').val() },
                dataType: 'json',
                success: function(resp) {
                    if (resp.status === 'success') {
                        alert_toast("Program outcome deleted successfully", 'success');
                        $(button).closest('tr').remove();
                        window.location.href = './?page=curriculum';
                    } else {
                        alert_toast(resp.msg || "An error occurred", 'error');
                    }
                    end_loader();
                },
                error: function(err) {
                    console.error("Error:", err);
                    alert_toast("An error occurred while deleting", 'error');
                    end_loader();
                }
            });
        }
    }

    $(document).ready(function () {
        $('#programOutcomesForm').submit(function(e) {
            e.preventDefault();
            
            var selected_outcomes = [];
            $('input[name="program_outcomes[]"]:checked').each(function() {
                selected_outcomes.push($(this).val());
            });
            
            var data = {
                course_id: $('input[name="course_id"]').val(),
                program_outcomes: selected_outcomes
            };

            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_program_outcome",
                method: 'POST',
                data: JSON.stringify(data),
                contentType: 'application/json',
                dataType: 'json',
                success: function(resp) {
                    if(resp.status == 'success') {
                        alert_toast(resp.msg, 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    } else {
                        alert_toast(resp.msg || "Error updating program outcomes", 'error');
                    }
                    end_loader();
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    alert_toast("An error occurred while saving", 'error');
                    end_loader();
                }
            });
        });
    });
</script>
