<?php
require_once('../../config.php');
$faculty_id = isset($_GET['id']) ? $_GET['id'] : '';
?>

<div class="container-fluid">
    <form action="" id="add-course-form">
        <input type="hidden" name="faculty_id" value="<?php echo $faculty_id; ?>">
        <div class="form-group">
            <label for="program_id" class="control-label">Program</label>
            <select name="program_id" id="program_id" class="form-control form-control-sm select2" required>
                <option value="" selected disabled>Select Program</option>
                <?php 
                $programs = $conn->query("SELECT * FROM `program_list` ORDER BY `name` ASC");
                while($row = $programs->fetch_assoc()):
                ?>
                <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="course_id" class="control-label">Course</label>
            <select name="course_id" id="course_id" class="form-control form-control-sm select2" required disabled>
                <option value="" selected disabled>Select Course</option>
            </select>
        </div>
        <!-- <div class="form-group text-center">
            <button class="btn btn-primary" type="submit">Add Course</button>
            <button class="btn btn-default" type="button" data-dismiss="modal">Cancel</button>
        </div> -->
    </form>
</div>

<script>
    $(document).ready(function() {
        // Initialize select2
        $('.select2').select2({
            width: '100%',
            placeholder: 'Please select here',
            allowClear: true
        });

        // When program is selected
        $('#program_id').change(function() {
            var program_id = $(this).val();
            $('#course_id').prop('disabled', true).html('<option value="" selected disabled>Select Course</option>');

            if(program_id) {
                // Load courses
                $.ajax({
                    url: _base_url_ + "classes/Master.php?f=get_courses_by_program",
                    method: 'POST',
                    data: { program_id: program_id },
                    dataType: 'json',
                    success: function(resp) {
                        if(resp.status == 'success') {
                            $('#course_id').prop('disabled', false);
                            resp.data.forEach(function(course) {
                                $('#course_id').append($('<option>', {
                                    value: course.id,
                                    text: course.catalog_number + ' - ' + course.course_title
                                }));
                            });
                        }
                    }
                });
            }
        });

        // Form submission
        $('#add-course-form').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=add_course_to_faculty",
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function(resp) {
                    if(resp.status == 'success') {
                        alert_toast("Course added successfully", 'success');
                        location.reload();
                    } else {
                        alert_toast(resp.msg || "An error occurred", 'error');
                    }
                    end_loader();
                },
                error: function(err) {
                    console.error(err);
                    alert_toast("An error occurred", 'error');
                    end_loader();
                }
            });
        });
    });
</script>
