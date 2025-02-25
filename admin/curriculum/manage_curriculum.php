<?php
require_once('../../config.php');
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `course_list` WHERE id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k = $v;
        }
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
    <form action="" id="curriculum-form" class="auto-height">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div class="form-group">
            <label for="catalog_number" class="control-label">Catalog Number</label>
            <input type="text" name="catalog_number" id="catalog_number" class="form-control form-control-sm" value="<?= isset($catalog_number) ? $catalog_number : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="course_title" class="control-label">Course Title</label>
            <input type="text" name="course_title" id="course_title" class="form-control form-control-sm" value="<?= isset($course_title) ? $course_title : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="credit_unit" class="control-label">Credit Unit</label>
            <input type="number" name="credit_unit" id="credit_unit" class="form-control form-control-sm" value="<?= isset($credit_unit) ? $credit_unit : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="semester" class="control-label">Semester</label>
            <select name="semester" id="semester" class="form-control form-control-sm" required>
                <option value="First" <?= isset($semester) && $semester == 'First' ? 'selected' : '' ?>>First</option>
                <option value="Second" <?= isset($semester) && $semester == 'Second' ? 'selected' : '' ?>>Second</option>
                <option value="Summer" <?= isset($semester) && $semester == 'Summer' ? 'selected' : '' ?>>Summer</option>
            </select>
        </div>
        <div class="form-group">
            <label for="year_level" class="control-label">Year Level</label>
            <select name="year_level" id="year_level" class="form-control form-control-sm" required>
                <option value="First" <?= isset($year_level) && $year_level == 'First' ? 'selected' : '' ?>>First</option>
                <option value="Second" <?= isset($year_level) && $year_level == 'Second' ? 'selected' : '' ?>>Second</option>
                <option value="Third" <?= isset($year_level) && $year_level == 'Third' ? 'selected' : '' ?>>Third</option>
                <option value="Fourth" <?= isset($year_level) && $year_level == 'Fourth' ? 'selected' : '' ?>>Fourth</option>
            </select>
        </div>
        <div class="form-group">
            <label for="program_id" class="control-label">Program</label>
            <select name="program_id" id="program_id" class="form-control form-control-sm" required>
                <?php 
                $dept = $conn->query("SELECT * FROM `program_list` ORDER BY `name` ASC");
                while($row = $dept->fetch_assoc()):
                ?>
                <option value="<?= $row['id'] ?>" <?= isset($program_id) && $program_id == $row['id'] ? 'selected' : '' ?>><?= $row['name'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="prerequisite" class="control-label">Prerequisite</label>
            <select name="prerequisite" id="prerequisite" class="form-control form-control-sm">
                <option value="">None</option>
                <?php 
                $courses = $conn->query("SELECT * FROM `course_list` WHERE delete_flag = 0 ORDER BY `catalog_number` ASC");
                while($row = $courses->fetch_assoc()):
                ?>
                <option value="<?= $row['id'] ?>" <?= isset($prerequisite) && $prerequisite == $row['id'] ? 'selected' : '' ?>><?= $row['catalog_number'] . ' - ' . $row['course_title'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function(){
        $('#curriculum-form').submit(function(e){
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_course",
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function(resp){
                    if(resp.status == 'success'){
                        alert_toast("Course saved successfully", 'success');
                        location.reload();
                    }else{
                        alert_toast(resp.msg || "An error occurred", 'error');
                    }
                },
                error: function(err){
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                }
            });
        });

        // Initialize Select2 for prerequisites
        $('#prerequisite').select2({
            placeholder: "Select prerequisites",
            allowClear: true
        });
    });
</script>