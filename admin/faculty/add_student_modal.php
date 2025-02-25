<?php
require_once('../../config.php');
$faculty_id = isset($_GET['faculty_id']) ? $_GET['faculty_id'] : '';
?>
<div class="container-fluid">
    <form action="" id="add-student-form">
        <input type="hidden" name="faculty_id" value="<?= $faculty_id ?>">
        <div class="form-group">
            <label for="student_id" class="control-label">Select Student</label>
            <select name="student_id" id="student_id" class="form-control form-control-sm form-control-border select2" required>
                <option value="" disabled selected></option>
                <?php 
                $students = $conn->query("SELECT *, CONCAT(lastname, ', ', firstname, ' ', middlename) as fullname FROM `student_list` WHERE status = 1 ORDER BY lastname ASC, firstname ASC");
                while($row = $students->fetch_assoc()):
                ?>
                    <option value="<?= $row['id'] ?>"><?= $row['fullname'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
    </form>
</div>
<script>
    $(function(){
        $('#add-student-form').submit(function(e){
            e.preventDefault();
            var _this = $(this);
            $('.pop-msg').remove();
            var el = $('<div>').addClass("pop-msg alert").hide();
            start_loader();
            $.ajax({
                url:_base_url_+"classes/Master.php?f=add_student",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error:err=>{
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                    end_loader();
                },
                success:function(resp){
                    if(resp.status == 'success'){
                        location.reload();
                    }else if(!!resp.msg){
                        el.addClass("alert-danger").text(resp.msg);
                        _this.prepend(el);
                    }else{
                        el.addClass("alert-danger").text("An error occurred due to unknown reason.");
                        _this.prepend(el);
                    }
                    el.show('slow');
                    $('html,body,.modal').animate({scrollTop:0},'fast');
                    end_loader();
                }
            });
        });
        $('#student_id').select2({
            placeholder: 'Select Student',
            width: '100%',
            dropdownParent: $('#uni_modal')
        });
    });
</script>