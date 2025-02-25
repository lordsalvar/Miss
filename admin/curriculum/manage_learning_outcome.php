<?php
require_once('../../config.php');
if(isset($_GET['id'])){
    $course_id = $_GET['id'];
    $qry = $conn->query("SELECT * FROM `learning_outcomes` WHERE `course_id` = '{$course_id}'");
    $learning_outcomes = [];
    while($row = $qry->fetch_assoc()){
        $learning_outcomes[] = $row;
    }
}
?>
<style>
img#cimg{
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
    -ms-overflow-style: -ms-autohiding-scrollbar;
    border: 1px solid #ddd;
}
.table-responsive .table {
    margin-bottom: 0;
}
#uni_modal .modal-dialog {
    max-width: 30%; /* Default modal width */
    width: auto;
    max-height: auto; /* Adjusted maximum height */
}
#uni_modal .modal-dialog.large-modal {
    max-width: 60%; /* Larger modal width for Program Outcomes */
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
    <form action="" id="learningOutcomesForm">
        <input type="hidden" name="course_id" value="<?php echo isset($course_id) ? $course_id : '' ?>">
        <div class="form-group">
            <label for="course_id" class="control-label">Course</label>
            <select name="course_id" id="course_id" class="form-control form-control-sm select2" required>
                <option value="">Select Course</option>
                <?php 
                $courses = $conn->query("SELECT c.*, p.name as program_name 
                                       FROM course_list c 
                                       LEFT JOIN program_list p ON p.id = c.program_id 
                                       WHERE p.name IN ('BSIT', 'BSCS') 
                                       AND c.delete_flag = 0 
                                       ORDER BY p.name ASC, c.catalog_number ASC");
                while($row = $courses->fetch_assoc()):
                ?>
                <option value="<?= $row['id'] ?>" 
                        <?= isset($course_id) && $course_id == $row['id'] ? 'selected' : '' ?>>
                    [<?= $row['program_name'] ?>] <?= $row['catalog_number'] ?> - <?= $row['course_title'] ?>
                </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <colgroup>
                    <col width="10%">
                    <col width="80%">
                    <col width="10%">
                </colgroup>
                <thead>
                    <tr>
                        <th>Learning Outcome Code</th>
                        <th>Learning Outcome</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="learningOutcomesTableBody">
                    <?php if(isset($learning_outcomes) && count($learning_outcomes) > 0): ?>
                        <?php foreach($learning_outcomes as $outcome): ?>
                        <tr data-id="<?= $outcome['id'] ?>">
                            <td contenteditable="true"><?= $outcome['learning_outcome_code'] ?></td>
                            <td contenteditable="true"><?= $outcome['learning_outcome'] ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDeleteLearningOutcomeRow(this, <?= $outcome['id'] ?>)">Delete</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td contenteditable="true"></td>
                            <td contenteditable="true"></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDeleteLearningOutcomeRow(this)">Delete</button>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <button type="button" class="btn btn-sm btn-primary" onclick="addLearningOutcomeRow()">Add New Learning Outcome</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>

<script>
    function addLearningOutcomeRow() {
        var newRow = `<tr>
                        <td contenteditable="true"></td>
                        <td contenteditable="true"></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDeleteLearningOutcomeRow(this)">Delete</button>
                        </td>
                    </tr>`;
        $('#learningOutcomesTableBody').append(newRow);
    }

    function confirmDeleteLearningOutcomeRow(button, id = null) {
        if (confirm("Are you sure you want to delete this learning outcome?")) {
            deleteLearningOutcomeRow(button, id);
        }
    }

    function deleteLearningOutcomeRow(button, id = null) {
        if (id) {
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=delete_learning_outcome",
                method: 'POST',
                data: { id: id },
                dataType: 'json',
                success: function(resp) {
                    if (resp.status === 'success') {
                        $(button).closest('tr').remove();
                        alert_toast("Learning outcome deleted successfully", 'success');
                    } else {
                        alert_toast(resp.msg || "An error occurred", 'error');
                    }
                },
                error: function(err) {
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                }
            });
        } else {
            $(button).closest('tr').remove();
        }
    }

    function editLearningOutcomeRow(button) {
        var row = $(button).closest('tr');
        row.find('td').attr('contenteditable', 'true').focus();
    }

    $(document).ready(function(){
        $('#learningOutcomesForm').submit(function (e) {
            e.preventDefault();
            var learningOutcomes = [];

            // Collect all rows
            $('#learningOutcomesTableBody tr').each(function () {
                var row = $(this);
                var id = row.data('id') || null;
                var code = row.find('td:eq(0)').text().trim();
                var outcome = row.find('td:eq(1)').text().trim();
                if (code && outcome) {
                    learningOutcomes.push({
                        id: id,
                        learning_outcome_code: code,
                        learning_outcome: outcome,
                    });
                }
            });

            var data = {
                course_id: $('#course_id').val(),
                learning_outcomes: JSON.stringify(learningOutcomes)
            };

            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_learning_outcome",
                method: 'POST',
                data: data,
                dataType: 'json',
                error: err => {
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                    end_loader();
                },
                success: function (resp) {
                    if (resp.status === 'success') {
                        alert_toast("Learning outcomes saved successfully", 'success');
                        location.reload();
                    } else {
                        alert_toast(resp.msg || "An error occurred", 'error');
                    }
                    end_loader();
                }
            });
        });

        // Initialize Select2 for course selection with custom formatting
        $('#course_id').select2({
            placeholder: "Select Course",
            allowClear: true,
            templateResult: formatCourse,
            templateSelection: formatCourse
        });

        function formatCourse(course) {
            if (!course.id) return course.text;
            var text = $(course.element).text();
            var parts = text.match(/\[(.*?)\] (.*)/);
            if (parts) {
                return $(`<span><strong>${parts[1]}</strong>: ${parts[2]}</span>`);
            }
            return text;
        }
    });
</script>
