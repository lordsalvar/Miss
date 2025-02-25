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

<style>
    img#cimg {
        height: 17vh;
        width: 25vw;
        object-fit: scale-down;
    }
    .tab-content {
        overflow-y: auto;
        max-height: 400px;
    }
    .table-responsive {
        width: 100%;
        margin-bottom: 15px;
        overflow-y: hidden;
        border: 1px solid #ddd;
    }
    #uni_modal .modal-dialog {
        max-width: 30%;
        width: auto;
    }
    #uni_modal .modal-dialog.large-modal {
        max-width: 60%;
    }
    .action-button-container {
        display: flex;
        justify-content: center;
    }
    .add-outcome-button {
        display: flex;
        justify-content: flex-start;
    }
    .auto-height {
        height: auto;
    }
</style>

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

        <!-- Program Outcomes Checkboxes -->
        <div class="form-group">
    <label class="control-label">Program Outcomes</label>
    <div id="program_outcomes_container">
        <?php 
        if($program_id) {
            $po_qry = $conn->query("SELECT * FROM program_outcomes WHERE program_id = '{$program_id}' ORDER BY po_code");
            while($row = $po_qry->fetch_assoc()):
                // Check if the outcome is in the selected outcomes array
                $is_checked = in_array($row['po_code'], $program_outcomes) ? 'checked' : '';
        ?>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="program_outcomes[]" 
                   value="<?= $row['po_code'] ?>" id="outcome_<?= $row['po_code'] ?>" <?= $is_checked ?>>
            <label class="form-check-label" for="outcome_<?= $row['po_code'] ?>">
                <?= $row['po_code']?>
            </label>
        </div>
        <?php endwhile;
        }
        ?>
    </div>
</div>

        <div class="form-group text-right">
            <button type="submit" class="btn btn-primary">Update Program Outcomes</button>
            <a href="./?page=curriculum" class="btn btn-default">Cancel</a>
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        $('#programOutcomesForm').submit(function(e) {
            e.preventDefault();
            
            // Get all checked checkboxes into an array
            var selected_outcomes = [];
            $('input[name="program_outcomes[]"]:checked').each(function() {
                selected_outcomes.push($(this).val());
            });
            
            // Important: Send even if no checkboxes are selected
            var data = {
                course_id: $('input[name="course_id"]').val(),
                program_id: $('input[name="program_id"]').val(),
                program_outcomes: selected_outcomes // Send as an array
            };

            console.log("Sending data:", data); // Debug log

            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_program_outcome",
                method: 'POST',
                data: JSON.stringify(data), // Send as JSON
                contentType: 'application/json',
                dataType: 'json',
                success: function(resp) {
                    console.log("Server response:", resp); // Debug log
                    if(resp.status == 'success') {
                        alert_toast("Program outcomes updated successfully", 'success');
                        setTimeout(() => {
                            location.href = "./?page=curriculum";
                        }, 1500);
                    } else {
                        alert_toast(resp.msg || "Error updating program outcomes", 'error');
                    }
                    end_loader();
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                    console.log("Response Text:", xhr.responseText);
                    alert_toast("Error updating program outcomes", 'error');
                    end_loader();
                }
            });
        });
    });
</script>
