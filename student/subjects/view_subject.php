<?php
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `course_list` c LEFT JOIN `subject_list` s ON s.`course_id` = c.`id` WHERE s.`id` = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
    }
}
?>
<div class="content py-4">
    <div class="card card-outline card-navy shadow rounded-0">
        <div class="card-header">
            <h5 class="card-title">Subject Details</h5>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary btn-flat" href="./?page=subjects/manage_subject&id=<?= isset($id) ? $id : '' ?>"><i class="fa fa-edit"></i> Edit</a>
                <button class="btn btn-sm btn-success btn-flat" id="add_student"><i class="fa fa-user-plus"></i> Add Student</button>
                <button class="btn btn-sm btn-danger btn-flat" id="delete_subject"><i class="fa fa-trash"></i> Delete</button>
                <a href="./?page=subjects" class="btn btn-default border btn-sm btn-flat"><i class="fa fa-angle-left"></i> Back to List</a>
            </div>
        </div>
        <div class="card-body">
            <div class="container-fluid" id="outprint">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label text-muted">Catalog Number</label>
                            <div class="pl-4"><?= isset($catalog_number) ? $catalog_number : 'N/A' ?></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label text-muted">Status</label>
                            <div class="pl-4">
                                <?php 
                                    switch ($status){
                                        case 0:
                                            echo '<span class="rounded-pill badge badge-secondary bg-gradient-secondary px-3">Inactive</span>';
                                            break;
                                        case 1:
                                            echo '<span class="rounded-pill badge badge-primary bg-gradient-primary px-3">Active</span>';
                                            break;
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <fieldset class="border-bottom">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label text-muted">Subject Title</label>
                                <div class="pl-4"><?= isset($course_title) ? $course_title : 'N/A' ?></div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend class="text-muted">Students under this Subject</legend>
                    <table class="table table-stripped table-bordered">
                        <colgroup>
                            <col width="5%">
                            <col width="45%">
                            <col width="25%">
                            <col width="25%">
                        </colgroup>
                        <thead>
                            <tr class="bg-gradient-dark">
                                <th class="py-1 text-center">#</th>
                                <th class="py-1 text-center">Name</th>
                                <th class="py-1 text-center">Status</th>
                                <th class="py-1 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i = 1;
                            // $students = $conn->query("SELECT s.*, CONCAT(s.lastname, ', ', s.firstname, ' ', s.middlename) as fullname FROM `student_list` s ORDER BY s.lastname ASC, s.firstname ASC");
                            $students = $conn->query("SELECT s.*, CONCAT(s.lastname, ', ', s.firstname, ' ', s.middlename) as fullname FROM `student_subject_list` ss LEFT JOIN `student_list` s ON ss.student_id = s.id WHERE ss.subject_id = '{$_GET['id']}' ORDER BY s.lastname ASC, s.firstname ASC");

                            while($row = $students->fetch_assoc()):
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
                                    <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                        Action
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                        <a class="dropdown-item view_student" href="javascript:void(0)" data-id ="<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> View</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item edit_student" href="javascript:void(0)" data-id ="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item delete_student" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </fieldset>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('#add_student').click(function(){
            uni_modal("Add Student to Subject","students/add_student_modal.php?subject_id=<?= isset($id) ? $id : '' ?>")
        })
        $('#delete_subject').click(function(){
			_conf("Are you sure to delete this Subject Information?","delete_subject",['<?= isset($id) ? $id : '' ?>'])
		})
        $('.view_student').click(function(){
            uni_modal("Student Details","students/view_student.php?id="+$(this).attr('data-id'))
        })
        $('.edit_student').click(function(){
            uni_modal("Edit Student Details","students/manage_student.php?id="+$(this).attr('data-id'))
        })
        $('.delete_student').click(function(){
            _conf("Are you sure to delete this Student from the Subject?","delete_student",[$(this).attr('data-id')])
        })
    })
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
            data:{id: $id, subject_id: '<?= isset($id) ? $id : '' ?>'},
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
</script>
