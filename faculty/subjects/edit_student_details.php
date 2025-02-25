<?php
require_once('../../config.php');

if(isset($_GET['id']) && isset($_GET['course_id'])){
    $student_id = $_GET['id'];
    $course_id = $_GET['course_id'];
    
    // Modified query to get student_subject_id
    $qry = $conn->query("SELECT u.*, ss.id as student_subject_id 
                        FROM user u 
                        INNER JOIN students_subject ss ON u.id = ss.student_id 
                        WHERE u.id = '{$student_id}' 
                        AND ss.course_id = '{$course_id}'");
    if($qry->num_rows > 0){
        $row = $qry->fetch_assoc();
    }
}
?>

<div class="container-fluid">
    <form action="" id="update-student-form">
        <input type="hidden" name="id" value="<?php echo isset($student_id) ? $student_id : ''; ?>">
        <input type="hidden" name="course_id" value="<?php echo isset($course_id) ? $course_id : ''; ?>">
        <input type="hidden" name="student_subject_id" value="<?php echo isset($row['student_subject_id']) ? $row['student_subject_id'] : ''; ?>">
        
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="firstname">First Name</label>
                    <input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo isset($row['firstname']) ? $row['firstname'] : ''; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="middlename">Middle Name</label>
                    <input type="text" name="middlename" id="middlename" class="form-control" value="<?php echo isset($row['middlename']) ? $row['middlename'] : ''; ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo isset($row['lastname']) ? $row['lastname'] : ''; ?>" required>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="1" <?php echo isset($row['status']) && $row['status'] == 1 ? 'selected' : ''; ?>>Active</option>
                <option value="0" <?php echo isset($row['status']) && $row['status'] == 0 ? 'selected' : ''; ?>>Inactive</option>
            </select>
        </div>

        <div class="form-group">
            <label for="roll">Student ID</label>
            <input type="text" name="roll" id="roll" class="form-control" value="<?php echo isset($row['roll']) ? $row['roll'] : ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="gender">Gender</label>
            <select name="gender" id="gender" class="form-control" required>
                <option value="Male" <?php echo isset($row['gender']) && $row['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo isset($row['gender']) && $row['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
            </select>
        </div>

        <div class="form-group">
            <label for="dob">Date of Birth</label>
            <input type="date" name="dob" id="dob" class="form-control" value="<?php echo isset($row['dob']) ? $row['dob'] : ''; ?>">
        </div>

        <div class="form-group">
            <label for="contact">Contact</label>
            <input type="text" name="contact" id="contact" class="form-control" value="<?php echo isset($row['contact']) ? $row['contact'] : ''; ?>">
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <textarea name="address" id="address" class="form-control"><?php echo isset($row['address']) ? $row['address'] : ''; ?></textarea>
        </div>

    </form>
</div>
<script>
$(document).ready(function(){
    $('#update-student-form').on('submit', function(e){
        e.preventDefault();
        var _this = $(this);
        $('.err-msg').remove();
        start_loader();
        $.ajax({
            url: _base_url_+"classes/Master.php?f=update_student_subject",
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
                    alert_toast(resp.msg, 'success');
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                }else if(resp.status == 'failed' && !!resp.msg){
                    var el = $('<div>')
                    el.addClass("alert alert-danger err-msg").text(resp.msg)
                    _this.prepend(el)
                    el.show('slow')
                    end_loader()
                }else{
                    alert_toast("An error occurred.", 'error');
                    end_loader();
                }
            }
        });
    });
});
</script>
