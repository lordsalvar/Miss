<?php
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT s.*, s.id as subject_id, c.*, c.id as c_id FROM `course_list` c LEFT JOIN `subject_list` s ON s.`course_id` = c.`id` where s.`id` = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
    }
}
?>
<div class="content py-3">
    <div class="card card-outline card-primary shadow rounded-0">
        <div class="card-header">
            <h3 class="card-title"><b><?= isset($id) ? "Update Subject Details - ". $course_title : "New Subject" ?></b></h3>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <form action="" id="subject_form">
                <input type="hidden" name="id" value="<?php echo isset($subject_id) ? $subject_id : '' ?>">
                    <fieldset class="border-bottom">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="course_id" class="control-label">Subject Title</label>
                                <select name="course_id" id="course_id" class="form-control form-control-sm rounded-0" required>
                                    <option value="" disabled <?= !isset($course_id) ? "selected" : "" ?>></option>
                                    <?php 
                                    $courses = $conn->query("SELECT * FROM `course_list`");
                                    while($row = $courses->fetch_assoc()):
                                    ?>
                                        <option value="<?= $row['id'] ?>" <?= isset($course_id) && $course_id == $row['id'] ? 'selected' : '' ?>><?= $row['course_title'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="school_year" class="control-label">School Year</label>
                                <select name="school_year" id="school_year" class="form-control form-control-sm rounded-0" required>
                                    <?php 
                                    $current_year = date("Y");
                                    for($i = $current_year; $i >= $current_year - 10; $i--):
                                    ?>
                                        <option value="<?= $i . '-' . ($i + 1) ?>" <?= isset($school_year) && $school_year == $i . '-' . ($i + 1) ? 'selected' : '' ?>><?= $i . '-' . ($i + 1) ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="semester" class="control-label">Semester</label>
                                <select name="semester" id="semester" class="form-control form-control-sm rounded-0" required>
                                    <option value="1" <?= isset($semester) && $semester == 1 ? 'selected' : '' ?>>1st Semester</option>
                                    <option value="2" <?= isset($semester) && $semester == 2 ? 'selected' : '' ?>>2nd Semester</option>
                                    <option value="3" <?= isset($semester) && $semester == 3 ? 'selected' : '' ?>>Summer</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="status" class="control-label">Status</label>
                                <select name="status" id="status" class="form-control form-control-sm rounded-0" required>
                                    <option value="1" <?= isset($status) && $status == 1 ? 'selected' : '' ?>>Active</option>
                                    <option value="0" <?= isset($status) && $status == 0 ? 'selected' : '' ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
        <div class="card-footer text-right">
            <button class="btn btn-flat btn-primary btn-sm" type="submit" form="subject_form">Save Subject Details</button>
            <a href="./?page=subjects" class="btn btn-flat btn-default border btn-sm">Cancel</a>
        </div>
    </div>
</div>

<script>
    $(function(){
        $('#subject_form').submit(function(e){
            e.preventDefault();
            var _this = $(this)
            $('.pop-msg').remove()
            var el = $('<div>')
                el.addClass("pop-msg alert")
                el.hide()
            start_loader();
            $.ajax({
                url:_base_url_+"classes/Master.php?f=save_subject",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: err => {
                    console.log(err)
                    alert_toast("An error occurred", 'error');
                    end_loader();
                },
                success: function(resp){
                    if(resp.status == 'success'){
                        console.log(resp)
                        location.href = "./?page=subjects";
                    } else if(!!resp.msg){
                        el.addClass("alert-danger")
                        el.text(resp.msg)
                        _this.prepend(el)
                    } else {
                        el.addClass("alert-danger")
                        el.text("An error occurred due to an unknown reason.")
                        _this.prepend(el)
                    }
                    el.show('slow')
                    $('html,body,.modal').animate({scrollTop:0}, 'fast')
                    end_loader();
                }
            })
        })
    })
</script>
