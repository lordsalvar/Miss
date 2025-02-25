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
                while ($row = $programs->fetch_assoc()):
                ?>
                    <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="course_id" class="control-label">Course</label>
            <select name="course_id" id="course_id" class="form-control form-control-sm select2" required>
                <option value="" selected disabled>Select Course</option>
            </select>
        </div>
        <div class="form-group">
            <label class="control-label">Program Outcomes</label>
            <div id="program_outcomes_container" class="mt-2">
                <!-- Program outcomes will be loaded here -->
            </div>
        </div>
        <div class="form-group text-center">
            <button class="btn btn-primary" type="submit">Save Program Outcomes</button>
            <button class="btn btn-default" type="button" data-dismiss="modal">Cancel</button>
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
        // Initialize select2
        $('.select2').select2({
            width: '100%',
            placeholder: 'Please select here'
        });

        // When program is selected
        $('#program_id').change(function() {
            var program_id = $(this).val();
            $('#course_id').html('<option value="" selected disabled>Select Course</option>');
            $('#program_outcomes_container').html('');

            if (program_id) {
                // Load courses
                $.ajax({
                    url: _base_url_ + "classes/Master.php?f=get_courses_by_program",
                    method: 'POST',
                    data: {
                        program_id: program_id
                    },
                    dataType: 'json',
                    success: function(resp) {
                        if (resp.status == 'success') {
                            resp.data.forEach(function(course) {
                                $('#course_id').append($('<option>', {
                                    value: course.id,
                                    text: course.catalog_number + ' - ' + course.course_title
                                }));
                            });
                            $('#course_id').select2('destroy').select2({
                                width: '100%',
                                placeholder: 'Please select here'
                            });
                        }
                    }
                });
            }
        });

        // When course is selected
        $('#course_id').change(function() {
            var course_id = $(this).val();
            var program_id = $('#program_id').val();
            $('#program_outcomes_container').html('');

            if (course_id) {
                // Load program outcomes and check existing ones for this course
                $.ajax({
                    url: _base_url_ + "classes/Master.php?f=get_course_program_outcomes",
                    method: 'POST',
                    data: {
                        program_id: program_id,
                        course_id: course_id
                    },
                    dataType: 'json',
                    success: function(resp) {
                        if (resp.status == 'success') {
                            // Updated outcome display format
                            resp.program_outcomes.forEach(function(outcome) {
                                var isChecked = resp.course_outcomes.includes(outcome.po_code) ? 'checked' : '';
                                $('#program_outcomes_container').append(`
                                    <div class="outcome-item">
                                        <div class="outcome-header">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" 
                                                    name="program_outcomes[]" 
                                                    value="${outcome.po_code}" 
                                                    id="po_${outcome.po_code}"
                                                    ${isChecked}>
                                                <label class="form-check-label" for="po_${outcome.po_code}">
                                                    <span class="outcome-code">${outcome.po_code}</span>
                                                </label>
                                            </div>
                                            <span class="outcome-toggle">[Show Description]</span>
                                        </div>
                                        <div class="outcome-description">
                                            ${outcome.description || 'No description available'}
                                        </div>
                                    </div>
                                `);
                            });

                            // Add click handler for description toggle
                            $('.outcome-toggle').click(function() {
                                const description = $(this).closest('.outcome-item').find('.outcome-description');
                                description.slideToggle();
                                $(this).text(description.is(':visible') ? '[Hide Description]' : '[Show Description]');
                            });
                        }
                    }
                });
            }
        });

        // Form submission
        $('#program-outcome-form').submit(function(e) {
            e.preventDefault();
            var selected_outcomes = [];

            $('input[name="program_outcomes[]"]:checked').each(function() {
                selected_outcomes.push($(this).val());
            });

            if (selected_outcomes.length === 0) {
                alert_toast('Please select at least one program outcome', 'warning');
                return false;
            }

            var catalog_number = $('#course_id option:selected').text().split(' - ')[0];

            var formData = {
                catalog_number: catalog_number,
                program_outcomes: selected_outcomes.join(',')
            };

            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=add_program_outcome",
                method: 'POST',
                data: formData,
                dataType: 'json',
                error: function(xhr, status, error) {
                    console.error("Ajax error:", error);
                    console.error("Response:", xhr.responseText);
                    alert_toast("An error occurred", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (resp.status == 'success') {
                        alert_toast(resp.msg || "Program outcomes saved successfully", 'success');
                        setTimeout(() => {
                            location.href = './?page=curriculum';
                        }, 1500);
                    } else {
                        alert_toast(resp.msg || "An error occurred", 'error');
                    }
                    end_loader();
                }
            });
        });
    });
</script>   