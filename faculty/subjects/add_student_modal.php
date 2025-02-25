<?php
?>
<div class="container-fluid">
    <form action="" id="add_student_form">
        <div class="form-group">
            <label for="student_id" class="control-label">Student</label>
            <select name="student_id" id="student_id" class="form-control form-control-sm rounded-0" required>
                <option value="" disabled selected>Select Student</option>
                <?php 
                $students = $conn->query("SELECT id, CONCAT(firstname, ' ', COALESCE(middlename, ''), ' ', lastname) as fullname 
                                        FROM user 
                                        WHERE type = 'student' 
                                        ORDER BY lastname ASC");
                while($row = $students->fetch_assoc()):
                ?>
                    <option value="<?= $row['id'] ?>"><?= $row['fullname'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        
        <input type="hidden" name="course_id" value="<?= isset($_GET['id']) ? $_GET['id'] : '' ?>">
        <input type="hidden" name="date_added" value="<?= date('Y-m-d H:i:s') ?>">
        
        <div class="form-group">
            <label for="status" class="control-label">Status</label>
            <select name="status" id="status" class="form-control form-control-sm rounded-0" required>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>

        <div class="form-group text-right">
            <button type="submit" class="btn btn-primary btn-sm">Add Student</button>
        </div>
    </form>
</div>
<script>
    $(function(){
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
                        el.text("An error occurred");
                        _this.prepend(el);
                    }
                    el.show('slow');
                    $('html,body,.modal').animate({scrollTop:0}, 'fast');
                    end_loader();
                }
            });
        });
    });
</script>
