<?php
require_once('../../config.php');
?>
<div class="container-fluid">
    <form action="" id="program-outcome-form">
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
        <div class="form-group">
            <label class="control-label">Program Outcomes</label>
            <div id="program_outcomes_container">
                <!-- Program outcomes will be loaded here -->
            </div>
        </div>
        <div class="form-group text-center">
            <button class="btn btn-primary" type="submit">Save Program Outcomes</button>
            <button class="btn btn-default" type="button" data-dismiss="modal">Cancel</button>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        // Initialize select2
        $('.select2').select2({
            width: '100%',
            placeholder: 'Please select here'
        });

        // When program is selected
        $('#program_id').change(function() {
            var program_id = $(this).val();
            $('#course_id').prop('disabled', true).html('<option value="" selected disabled>Select Course</option>');
            $('#program_outcomes_container').html('');

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

                // Load program outcomes
                $.ajax({
                    url: _base_url_ + "classes/Master.php?f=get_program_outcomes_by_program",
                    method: 'POST',
                    data: { program_id: program_id },
                    dataType: 'json',
                    success: function(resp) {
                        if(resp.status == 'success') {
                            resp.data.forEach(function(outcome) {
                                $('#program_outcomes_container').append(
                                    `<div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="program_outcomes[]" 
                                            value="${outcome.po_code}" id="po_${outcome.po_code}">
                                        <label class="form-check-label" for="po_${outcome.po_code}">
                                            ${outcome.po_code}
                                        </label>
                                    </div>`
                                );
                            });
                        }
                    }
                });
            }
        });

        // Form submission
        $('#program-outcome-form').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var selected_outcomes = [];
            
            $('input[name="program_outcomes[]"]:checked').each(function() {
                selected_outcomes.push($(this).val());
            });

            if(selected_outcomes.length === 0) {
                alert_toast('Please select at least one program outcome', 'warning');
                return false;
            }

            var data = {
                course_id: $('#course_id').val(),
                program_outcomes: selected_outcomes.join(',')
            };

            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_program_outcome",
                method: 'POST',
                data: data,
                dataType: 'json',
                success: function(resp) {
                    if(resp.status == 'success') {
                        alert_toast("Program outcomes saved successfully", 'success');
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
