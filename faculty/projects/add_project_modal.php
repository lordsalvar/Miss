<?php
require_once('../../config.php');
?>
<div class="container-fluid">
    <form action="" id="add_project_form">
        <input type="hidden" name="subject_id" value="<?php echo isset($_GET['subject_id']) ? $_GET['subject_id'] : '' ?>">
        <div class="form-group">
            <label for="project_title" class="control-label">Project Title</label>
            <input type="text" name="project_title" id="project_title" class="form-control form-control-sm rounded-0" required>
        </div>
        <div class="form-group">
            <label for="description" class="control-label">Description</label>
            <textarea name="description" id="description" rows="4" class="form-control form-control-sm rounded-0" required></textarea>
        </div>
        <div class="form-group">
            <label for="project_file" class="control-label">Final Project Instruction File</label>
            <input type="file" name="project_file" id="project_file" class="form-control form-control-sm rounded-0" required>
        </div>
        <div class="form-group">
            <label for="due_date" class="control-label">Due Date</label>
            <input type="date" name="due_date" id="due_date" class="form-control form-control-sm rounded-0" required>
        </div>
    </form>
</div>
<script>
    $(function(){
        $('#add_project_form').submit(function(e){
            e.preventDefault();
            var _this = $(this);
            $('.pop-msg').remove();
            var el = $('<div>');
                el.addClass("pop-msg alert");
                el.hide();
            start_loader();
            $.ajax({
                url:_base_url_+"classes/Master.php?f=save_project",
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
    });
</script>

