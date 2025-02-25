<?php
require_once('../../config.php');
?>

<div class="container-fluid">
    <form action="" id="manage-course-form">
        <input type="hidden" name="student_id" value="<?= isset($_GET['student_id']) ? $_GET['student_id'] : '' ?>">
        <div class="form-group">
            <label for="school_year" class="control-label">School Year</label>
            <input type="text" name="school_year" id="school_year" class="form-control form-control-sm" required>
        </div>
        <div class="form-group">
            <label for="semester" class="control-label">Semester</label>
            <select name="semester" id="semester" class="form-control form-control-sm" required>
                <option value="1">1st Semester</option>
                <option value="2">2nd Semester</option>
                <option value="3">Summer</option>
            </select>
        </div>
        <div class="form-group">
            <label for="courses" class="control-label">Courses</label>
            <select name="courses[]" id="courses" class="form-control form-control-sm select2" multiple required>
                <?php
                $courses = $conn->query("SELECT * FROM course_list ORDER BY course_title ASC");
                if($courses->num_rows > 0):
                    while($row = $courses->fetch_assoc()):
                ?>
                    <option value="<?= $row['id'] ?>"><?= $row['course_title'] ?> (<?= $row['catalog_number'] ?>)</option>
                <?php 
                    endwhile;
                else:
                ?>
                    <option value="">No courses available</option>
                <?php endif; ?>
            </select>
        </div>
    </form>
</div>
<script>
    $(document).ready(function(){
        $('#courses').select2({
            placeholder: "Select Courses",
            width: '100%'
        });
        $('#manage-course-form').submit(function(e){
            e.preventDefault();
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_course",
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                error: err => {
                    console.log(err);
                    alert_toast("An error occurred.", 'error');
                    end_loader();
                },
                success: function(resp){
                    if(typeof resp == 'object' && resp.status == 'success'){
                        location.reload();
                    } else {
                        alert_toast("An error occurred.", 'error');
                        end_loader();
                    }
                }
            });
        });
    });
</script>
