<?php
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT *, CONCAT(lastname,', ', firstname,' ', middlename) as fullname FROM `user` WHERE id = '{$_GET['id']}' AND `type` = 'faculty'");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
    }

    // Fetch courses handled by the faculty
    $courses_qry = $conn->query("SELECT c.catalog_number, c.course_title, p.name as program_name 
                                 FROM `course_list` c 
                                 INNER JOIN `program_list` p ON c.program_id = p.id 
                                 INNER JOIN `faculty_courses` fc ON c.id = fc.course_id 
                                 WHERE fc.faculty_id = '{$_GET['id']}' 
                                 ORDER BY c.catalog_number ASC");
}
?>
<div class="container-fluid">
    <div class="card card-outline card-primary rounded-0 shadow">
        <div class="card-header">
            <h3 class="card-title">Faculty Details</h3>
            <div class="card-tools">
                <a href="javascript:void(0)" id="add_course" class="btn btn-flat btn-sm btn-success"><span class="fas fa-plus"></span> Add Course</a>
                <a href="./?page=faculty/findex" class="btn btn-flat btn-sm btn-primary"><span class="fas fa-arrow-left"></span> Back to List</a>
            </div>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label text-muted">Faculty ID</label>
                            <div class="pl-4"><?= isset($roll) ? $roll : 'N/A' ?></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label text-muted">Name</label>
                            <div class="pl-4"><?= isset($fullname) ? $fullname : 'N/A' ?></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label text-muted">Gender</label>
                            <div class="pl-4"><?= isset($gender) ? $gender : 'N/A' ?></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label text-muted">Date of Birth</label>
                            <div class="pl-4"><?= isset($dob) && !empty($dob) && $dob != '0000-00-00' ? date("M d, Y", strtotime($dob)) : 'N/A' ?></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label text-muted">Status</label>
                            <div class="pl-4">
                                <?php 
                                    if (isset($status)) {
                                        switch ($status){
                                            case 0:
                                                echo '<span class="rounded-pill badge badge-secondary bg-gradient-secondary px-3">Inactive</span>';
                                                break;
                                            case 1:
                                                echo '<span class="rounded-pill badge badge-primary bg-gradient-primary px-3">Active</span>';
                                                break;
                                        }
                                    } else {
                                        echo 'N/A';
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label text-muted">Contact #</label>
                            <div class="pl-4"><?= isset($contact) ? $contact : 'N/A' ?></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label text-muted">Address</label>
                            <div class="pl-4"><?= isset($address) ? $address : 'N/A' ?></div>
                        </div>
                    </div>
                </div>
                <hr>
                <h5 class="text-muted">Courses Handled</h5>
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr class="bg-gradient-dark text-light">
                            <th>#</th>
                            <th>Catalog Number</th>
                            <th>Course Title</th>
                            <th>Program</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1;
                        while($course = $courses_qry->fetch_assoc()):
                        ?>
                        <tr>
                            <td class="text-center"><?= $i++ ?></td>
                            <td><?= $course['catalog_number'] ?></td>
                            <td><?= $course['course_title'] ?></td>
                            <td><?= $course['program_name'] ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#add_course').click(function(){
            uni_modal("Add Course to this Faculty", "faculty/add_course.php?id=<?= isset($id) ? $id : '' ?>&program=<?= isset($program) ? $program : '' ?>");
        });
    });
</script>