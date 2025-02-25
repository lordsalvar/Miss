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
        if (!empty($course_details['po_codes'])) {
            $program_outcomes = explode(',', $course_details['po_codes']);
        }
    }
}
?>

<div class="container-fluid">
    <form action="" id="programOutcomesForm">
        <!-- Course Details Display -->
        <?php if (isset($course_details)): ?>
            <div class="form-group">
                <label class="control-label">Selected Course Details:</label>
                <div class="pl-4">
                    <p><strong>Program:</strong> <?= $course_details['program_name'] ?></p>
                    <p><strong>Course:</strong> <?= $course_details['catalog_number'] . ' - ' . $course_details['course_title'] ?></p>
                </div>
            </div>
        <?php endif; ?>

        <!-- Program Outcomes Table -->
        <div class="form-group">
            <label class="control-label">Program Outcomes</label>
            <div id="program_outcomes_container" class="mt-2">
                <?php
                if ($program_id) {
                    $po_qry = $conn->query("SELECT po_code, description FROM program_outcomes 
                                          WHERE program_id = '{$program_id}' 
                                          ORDER BY po_code");
                    while ($row = $po_qry->fetch_assoc()):
                        $is_checked = in_array($row['po_code'], $program_outcomes) ? 'checked' : '';
                ?>
                        <div class="outcome-item">
                            <div class="outcome-header">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        name="program_outcomes[]"
                                        value="<?= $row['po_code'] ?>"
                                        id="outcome_<?= $row['po_code'] ?>"
                                        <?= $is_checked ?>>
                                    <label class="form-check-label" for="outcome_<?= $row['po_code'] ?>">
                                        <span class="outcome-code"><?= htmlspecialchars($row['po_code']) ?></span>
                                    </label>
                                </div>
                                <span class="outcome-toggle">[Show Description]</span>
                            </div>
                            <div class="outcome-description">
                                <?= htmlspecialchars($row['description']) ?>
                            </div>
                        </div>
                <?php
                    endwhile;
                }
                ?>
            </div>
        </div>

        <div class="form-group text-center">
            <button type="submit" class="btn btn-primary">Update Program Outcomes</button>
            <a href="./?page=curriculum" class="btn btn-default">Cancel</a>
        </div>
    </form>
</div>

<style>
    .outcome-item {
        border: 1px solid #dee2e6;
        border-radius: 4px;
        margin-bottom: 8px;
        padding: 10px;
        background-color: #f8f9fa;
    }

    .outcome-header {
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }

    .outcome-code {
        font-weight: bold;
        min-width: 80px;
    }

    .outcome-description {
        margin-top: 8px;
        padding-left: 25px;
        color: #666;
        display: none;
    }

    .outcome-toggle {
        cursor: pointer;
        color: #0056b3;
        font-size: 0.8em;
        margin-left: auto;
    }

    .form-check-input {
        margin-top: 3px;
    }
</style>

<script>
    $(document).ready(function() {
        // Add click handler for description toggle
        $('.outcome-toggle').click(function() {
            const description = $(this).closest('.outcome-item').find('.outcome-description');
            description.slideToggle();
            $(this).text(description.is(':visible') ? '[Hide Description]' : '[Show Description]');
        });

        $('#programOutcomesForm').submit(function(e) {
            e.preventDefault();
            var selected_outcomes = [];

            $('input[name="program_outcomes[]"]:checked').each(function() {
                selected_outcomes.push($(this).val());
            });

            var formData = {
                catalog_number: '<?php echo $course_details['catalog_number'] ?>',
                program_outcomes: selected_outcomes.join(',')
            };

            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=edit_program_outcome", // Changed to edit endpoint
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function(resp) {
                    if (resp.status == 'success') {
                        alert_toast(resp.msg || "Program outcomes updated successfully", 'success');
                        setTimeout(() => {
                            location.href = './?page=curriculum';
                        }, 1500);
                    } else {
                        alert_toast(resp.msg || "Error updating program outcomes", 'error');
                    }
                    end_loader();
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    console.error("Response:", xhr.responseText);
                    alert_toast("An error occurred while saving", 'error');
                    end_loader();
                }
            });
        });
    });
</script>