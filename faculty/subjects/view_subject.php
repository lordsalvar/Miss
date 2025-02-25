<?php
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT c.* 
                         FROM `course_list` c 
                         WHERE c.id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        $catalog_number = $res['catalog_number'];
        $course_title = $res['course_title'];
        $course_id = $res['id'];
    } else {
        $catalog_number = 'N/A';
        $course_title = 'N/A';
        $course_id = 0;
    }
} else {
    $catalog_number = 'N/A';
    $course_title = 'N/A';
    $course_id = 0;
}
?>

<!-- Add these CSS styles -->
<style>
    .card {
        border: none;
        box-shadow: 0 0 20px rgba(0,0,0,0.1) !important;
        border-radius: 15px !important;
    }
    
    .card-header {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
        border-radius: 15px 15px 0 0 !important;
        padding: 1.5rem !important;
    }

    .card-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
    }

    .btn {
        border-radius: 8px;
        padding: 8px 15px;
        transition: all 0.3s;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .subject-info {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .subject-info label {
        color: #6c757d;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .subject-info .pl-4 {
        font-size: 1.1rem;
        color: #2a5298;
        font-weight: 500;
    }

    .table {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
    }

    .table thead tr {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    }

    .table thead th {
        color: white;
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.9rem;
        padding: 15px !important;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
        transition: all 0.2s;
    }

    .table td {
        padding: 12px !important;
        vertical-align: middle;
    }

    .badge {
        padding: 8px 12px;
        font-weight: 500;
    }

    .badge-primary {
        background: #2a5298 !important;
    }

    .badge-secondary {
        background: #6c757d !important;
    }

    .dropdown-menu {
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        border-radius: 8px;
    }

    .dropdown-item {
        padding: 8px 20px;
        transition: all 0.2s;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
        color: #2a5298;
    }

    /* Grade table styling */
    .grade-table {
        margin: 0;
        min-width: 150px;
    }

    .grade-table td {
        padding: 5px !important;
        text-align: center;
    }

    .grade-table td:first-child {
        font-weight: 600;
        color: #2a5298;
    }

    .grade-table td:last-child {
        font-size: 1.1rem;
        color: #28a745;
    }

    /* Animations */
    .card {
        animation: slideIn 0.5s ease-out;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Modal enhancements */
    .modal-content {
        border: none;
        border-radius: 15px;
    }

    .modal-header {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
        border-radius: 15px 15px 0 0;
    }

    .modal-body {
        padding: 2rem;
    }

    .select2-container--default .select2-selection--single {
        border-radius: 8px;
        height: 40px;
        line-height: 40px;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }

    /* Loading spinner enhancement */
    .loader {
        border: 4px solid #f3f3f3;
        border-radius: 50%;
        border-top: 4px solid #2a5298;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<!-- Modify the card header -->
<div class="content py-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-title mb-1"><?= $course_title ?></h5>
                <small class="text-white"><?= $catalog_number ?></small>
            </div>
            <div class="card-tools d-flex gap-2">
                <button class="btn btn-light btn-sm" data-toggle="modal" data-target="#addStudentModal">
                    <i class="fa fa-user-plus"></i> Add Student
                </button>
                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#gradeModal">
                    <i class="fa fa-star"></i> Add Grade
                </button>
                <button class="btn btn-danger btn-sm" id="delete_subject">
                    <i class="fa fa-trash"></i> Delete
                </button>
                <a href="./?page=subjects" class="btn btn-light btn-sm">
                    <i class="fa fa-angle-left"></i> Back
                </a>
            </div>
        </div>

        <!-- Modify the table to add modern styling -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Student Name</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Grades</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1;
                        $students = $conn->query("SELECT 
                            u.*, 
                            ss.id as student_subject_id,
                            ss.status as enrollment_status,
                            CONCAT(u.firstname, ' ', COALESCE(u.middlename, ''), ' ', u.lastname) as fullname,
                            GROUP_CONCAT(
                                DISTINCT CONCAT(sg.po_code, ':', COALESCE(sg.grade, 'N/A'))
                                ORDER BY sg.po_code ASC
                                SEPARATOR ','
                            ) as grades
                        FROM students_subject ss 
                        INNER JOIN user u ON u.id = ss.student_id 
                        LEFT JOIN student_grades sg ON sg.student_id = u.id 
                            AND sg.course_id = ss.course_id 
                        WHERE ss.course_id = '{$_GET['id']}'
                        GROUP BY u.id, ss.id, ss.status
                        ORDER BY u.lastname ASC, u.firstname ASC");

                        while($row = $students->fetch_assoc()):
                            // Convert grades string to array
                            $grade_array = [];
                            if (!empty($row['grades'])) {
                                $grades = explode(',', $row['grades']);
                                foreach($grades as $g) {
                                    list($po_code, $grade) = explode(':', $g);
                                    $grade_array[$po_code] = $grade;
                                }
                            }
                        ?>
                        <tr>
                            <td class="py-1 text-center px-2 align-middle sorting_desc"><?= $i++; ?></td>
                            <td class="px-2 py-1 align-middle"><?= $row['fullname'] ?></td>
                            <td class="px-2 py-1 align-middle text-center">
                                <?php 
                                switch($row['status']){
                                    case 0:
                                        echo '<span class="rounded-pill badge badge-secondary px-3">Inactive</span>';
                                        break;
                                    case 1:
                                        echo '<span class="rounded-pill badge badge-primary px-3">Active</span>';
                                        break;
                                }
                                ?>
                            </td>
                            <td class="px-2 py-1 align-middle text-center">
                                <?php 
                                if (!empty($grade_array)) {
                                    echo "<table class='table table-sm table-bordered mb-0'>";
                                    foreach ($grade_array as $po_code => $grade) {
                                        echo "<tr>
                                            <td>{$po_code}</td>
                                            <td>" . number_format($grade, 1) . "</td>
                                        </tr>";
                                    }
                                    echo "</table>";
                                } else {
                                    echo 'N/A';
                                }
                                ?>
                            </td>
                            <td class="px-2 py-1 align-middle text-center">
                                <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                    Action
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item view_student" href="javascript:void(0)" data-id ="<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> View</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item edit_student" href="javascript:void(0)" data-id ="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item grade_student" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-star text-warning"></span> Update Grade</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item delete_student" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Remove Student</a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Student Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Student to Subject</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php include('add_student_modal.php'); ?>
                <input type="hidden" name="course_id" value="<?= isset($course_id) ? $course_id : '' ?>">
            </div>
        </div>
    </div>
</div>
<!-- Edit Student Modal -->
<div class="modal fade" id="editStudentModal" tabindex="-1" role="dialog" aria-labelledby="editStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Student Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="edit_student_details"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="update-student-form" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Replace the existing Grade Modal with this new one -->
<div class="modal fade" id="gradeModal" tabindex="-1" role="dialog" aria-labelledby="gradeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Student Grade</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="grade-form">
                    <input type="hidden" name="course_id" value="<?= isset($_GET['id']) ? $_GET['id'] : '' ?>">
                    
                    <!-- Student Selection -->
                    <div class="form-group">
                        <label for="student_select">Select Student</label>
                        <select class="form-control select2" id="student_select" name="id" required>
                            <option value="">Select a student...</option>
                            <?php 
                            $students = $conn->query("SELECT u.id, u.firstname, u.lastname, ss.grade 
                                                    FROM students_subject ss 
                                                    INNER JOIN user u ON ss.student_id = u.id 
                                                    WHERE ss.course_id = '{$_GET['id']}' 
                                                    ORDER BY u.lastname, u.firstname");
                            while($student = $students->fetch_assoc()):
                            ?>
                            <option value="<?= $student['id'] ?>" data-grade="<?= $student['grade'] ?>">
                                <?= $student['lastname'] . ', ' . $student['firstname'] ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <!-- Program Outcomes Table -->
                    <div class="form-group">
                        <label>Program Outcomes Assessment</label>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Program Outcome</th>
                                        <th>Description</th>
                                        <th style="width: 150px;">Score (1.0-9.0)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $po_qry = $conn->query("SELECT po.po_code, po.description 
                                                          FROM program_outcomes po 
                                                          INNER JOIN course_list c ON FIND_IN_SET(po.po_code, c.program_outcomes)
                                                          WHERE c.id = '{$_GET['id']}' 
                                                          ORDER BY po.po_code");
                                    while($row = $po_qry->fetch_assoc()):
                                    ?>
                                    <tr>
                                        <td><strong><?= $row['po_code'] ?></strong></td>
                                        <td><?= $row['description'] ?></td>
                                        <td>
                                            <input type="number" 
                                                   name="scores[<?= $row['po_code'] ?>]" 
                                                   class="form-control" 
                                                   min="1.0" 
                                                   max="9.0" 
                                                   step="0.1" 
                                                   required 
                                                   placeholder="1.0-9.0"
                                                   onchange="validateGrade(this)">
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- <div class="form-group">
                        <label for="final_grade">Final Grade</label>
                        <input type="number" 
                               name="final_grade" 
                               id="final_grade" 
                               class="form-control" 
                               step="0.01" 
                               min="0" 
                               max="100" 
                               required>
                    </div> -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="grade-form" class="btn btn-primary">Save Grade</button>
            </div>
        </div>
    </div>
</div>

<!-- Add this CSS -->
<style>
    .modal-xl {
        max-width: 95% !important;
    }
    .select2-container {
        width: 100% !important;
    }
    .table td {
        vertical-align: middle !important;
    }
    .form-control[type=number] {
        width: 100px;
        margin: 0 auto;
    }
    #final_grade {
        width: 200px;
    }
</style>

<script>
    $(function() {
        $('#add_project').click(function(){
            uni_modal("Add Project to Subject","projects/add_project_modal.php?course_id=<?= isset($_GET['id']) ? $_GET['id'] : '' ?>")
        })
        $('#delete_subject').click(function(){
			_conf("Are you sure to delete this Subject Information?","delete_subject",['<?= isset($_GET['id']) ? $_GET['id'] : '' ?>'])
		})
        $('.view_student').click(function(){
            var student_id = $(this).attr('data-id');
            var course_id = '<?= isset($_GET['id']) ? $_GET['id'] : '' ?>';
            uni_modal("", "subjects/view_student_details.php?id="+student_id+"&course_id="+course_id, "mid-large");
        })
        $('.edit_student').click(function(){
            var id = $(this).attr('data-id');
            var course_id = '<?= isset($_GET['id']) ? $_GET['id'] : '' ?>';
            $('#editStudentModal').modal('show');
            $('#edit_student_details').load("subjects/edit_student_details.php?id="+id+"&course_id="+course_id, function(){
                // Initialize any necessary plugins or events after loading content
                $('.select2').select2();
            });
        });
        $('.program_outcomes').click(function() {
            var id = $(this).attr('data-id'); // Ensure data-id is being set correctly
            uni_modal("Subject Program Outcomes", "subjects/view_program_outcomes.php?course_id=" + id);
        });
        $('.delete_student').click(function(){
            _conf("Are you sure to delete this Student from the Subject?","delete_student",[$(this).attr('data-id')])
        })

        $('.grade_student').click(function(){
            var studentId = $(this).attr('data-id');
            var studentName = $(this).closest('tr').find('td:nth-child(2)').text().trim(); // Get student name from table
            
            // Reset form
            $('#grade-form')[0].reset();
            
            // Set selected student in dropdown
            var studentOption = new Option(studentName, studentId, true, true);
            $('#student_select').append(studentOption).trigger('change');
            
            // Load existing grades
            loadStudentGrades(studentId);
            
            $('#gradeModal').modal('show');
        });

        function loadStudentGrades(studentId) {
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=get_student_grades",
                method: 'POST',
                data: {
                    student_id: studentId,
                    course_id: $('input[name="course_id"]').val()
                },
                dataType: 'json',
                success: function(resp) {
                    if(resp.status == 'success') {
                        // Fill in program outcome scores
                        if(resp.po_scores) {
                            Object.keys(resp.po_scores).forEach(function(po_code) {
                                $(`input[name="scores[${po_code}]"]`).val(resp.po_scores[po_code]);
                            });
                        }
                        
                        // Set final grade
                        if(resp.final_grade) {
                            $('#final_grade').val(resp.final_grade);
                        }
                    }
                },
                error: function(err) {
                    console.error(err);
                    alert_toast("Failed to load grades", 'error');
                }
            });
        }

        // When selecting a different student
        $('#student_select').change(function() {
            var studentId = $(this).val();
            if(studentId) {
                loadStudentGrades(studentId);
            }
        });

        $('#grade-form').submit(function(e){
            e.preventDefault();
            
            // Validate all grade inputs
            let isValid = true;
            $('input[type="number"]').each(function() {
                let value = parseFloat($(this).val());
                if (isNaN(value) || value < 1.0 || value > 9.0) {
                    alert("All grades must be between 1.0 and 9.0");
                    isValid = false;
                    return false;
                }
            });

            if (!isValid) return;

            // Rest of your existing form submission code
            var _this = $(this);
            $('.err-msg').remove();
            start_loader();
            $.ajax({
                url: _base_url_+"classes/Master.php?f=update_student_grade",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: function(err){
                    console.log(err);
                    alert_toast("An error occurred.", 'error');
                    end_loader();
                },
                success: function(resp){
                    if(typeof resp == 'object' && resp.status == 'success'){
                        location.reload();
                    }else{
                        alert_toast("An error occurred.", 'error');
                    }
                    end_loader();
                }
            });
        });

        $('#addStudentModal').on('shown.bs.modal', function () {
            $('#add_student_form').trigger('reset');
        });

        $('#add_student_form').submit(function(e){
            e.preventDefault();
            var _this = $(this);
            $('.pop-msg').remove();
            var el = $('<div>');
                el.addClass("pop-msg alert");
                el.hide();
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=add_student_to_subject",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: err => {
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                    end_loader();
                },
                success: function(resp){
                    if(resp.status == 'success'){
                        location.reload();
                    } else if(!!resp.msg){
                        el.addClass("alert-danger");
                        el.text(resp.msg);
                        _this.prepend(el);
                    } else {
                        el.addClass("alert-danger");
                        el.text("An error occurred due to an unknown reason.");
                        _this.prepend(el);
                    }
                    el.show('slow');
                    $('html,body,.modal').animate({scrollTop:0}, 'fast');
                    end_loader();
                }
            });
        });

        // Update grade field when student is selected
        $('#student_select').change(function() {
            var selectedOption = $(this).find('option:selected');
            var grade = selectedOption.data('grade');
            $('#grade').val(grade || '');
        });
    });
    function delete_subject($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_subject",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.href="./?page=subjects";
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
    function delete_student($id){
        start_loader();
        $.ajax({
            url:_base_url_+"classes/Master.php?f=delete_student_from_subject",
            method:"POST",
            data:{id: $id, course_id: '<?= isset($_GET['id']) ? $_GET['id'] : '' ?>'},
            dataType:"json",
            error:err=>{
                console.log(err)
                alert_toast("An error occured.",'error');
                end_loader();
            },
            success:function(resp){
                if(typeof resp== 'object' && resp.status == 'success'){
                    location.reload();
                }else{
                    alert_toast("An error occured.",'error');
                    end_loader();
                }
            }
        })
    }

    // Add this function to your existing JavaScript
    function validateGrade(input) {
        let value = parseFloat(input.value);
        if (value < 1.0 || value > 9.0) {
            alert("Please enter a grade between 1.0 and 9.0");
            input.value = "";
            return false;
        }
        // Format to one decimal place
        input.value = value.toFixed(1);
        return true;
    }

    // Add this to your existing JavaScript
    $(document).ready(function() {
        // Add smooth scrolling
        $('html, body').animate({scrollTop: 0}, 'slow');

        // Add hover effects to buttons
        $('.btn').hover(
            function() { $(this).addClass('shadow-sm'); },
            function() { $(this).removeClass('shadow-sm'); }
        );

        // Enhance table row hover
        $('.table tbody tr').hover(
            function() { $(this).addClass('shadow-sm'); },
            function() { $(this).removeClass('shadow-sm'); }
        );

        // Add fade effects to alerts
        function showAlert(message, type) {
            const alert = $('<div>')
                .addClass(`alert alert-${type} alert-dismissible fade show`)
                .attr('role', 'alert')
                .html(`
                    ${message}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                `);
            
            $('.content').prepend(alert);
            setTimeout(() => alert.alert('close'), 3000);
        }

        // Enhance loading visualization
        function enhancedStartLoader() {
            const loader = $('<div>').addClass('loader');
            const overlay = $('<div>')
                .css({
                    position: 'fixed',
                    top: 0,
                    left: 0,
                    width: '100%',
                    height: '100%',
                    background: 'rgba(255,255,255,0.8)',
                    display: 'flex',
                    justifyContent: 'center',
                    alignItems: 'center',
                    zIndex: 9999
                })
                .append(loader);
            
            $('body').append(overlay);
            return overlay;
        }

        // Replace existing loader functions
        window.start_loader = function() {
            window.activeLoader = enhancedStartLoader();
        }

        window.end_loader = function() {
            if(window.activeLoader) {
                window.activeLoader.fadeOut('fast', function() {
                    $(this).remove();
                });
            }
        }
    });
</script>
