<style>
    .img-thumb-path{
        width:100px;
        height:80px;
        object-fit:scale-down;
        object-position:center center;
    }

</style>
<div class="card card-outline card-primary rounded-0 shadow">
    <div class="card-header">
        <h3 class="card-title">List of Courses</h3>
        <?php if($_settings->userdata('type') == 'Administrator'): ?>
        <div class="card-tools">
            <a href="javascript:void(0)" id="create_new" class="btn btn-flat btn-sm btn-primary"><span class="fas fa-plus"></span>  Add New Course</a>
            <a href="javascript:void(0)" id="add_learning_outcome" class="btn btn-flat btn-sm btn-secondary"><span class="fas fa-plus"></span> Add Learning Outcome</a>
            <a href="javascript:void(0)" id="add_program_outcome" class="btn btn-flat btn-sm btn-secondary"><span class="fas fa-plus"></span> Add Program Outcome</a>
        </div>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="form-group">
                <label for="program_filter" class="control-label">Filter by Program</label>
                <select id="program_filter" class="form-control form-control-sm">
                    <option value="">All Programs</option>
                    <?php 
                    $programs = $conn->query("SELECT * FROM `program_list` ORDER BY `name` ASC");
                    while($row = $programs->fetch_assoc()):
                    ?>
                    <option value="<?= $row['id'] ?>" <?= $row['name'] == 'BSIT' ? 'selected' : '' ?>><?= $row['name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <table class="table table-bordered table-hover table-striped">
                <colgroup>
                    <col width="20%">
                    <col width="25%">
                    <col width="15%">
                    <col width="15%">
                    <col width="15%">
                </colgroup>
                <thead>
                    <tr class="bg-gradient-dark text-light">
                        <th>Catalog Number</th>
                        <th>Course Title</th>
                        <th>Credit Unit</th>
                        <th>Program</th>
                        <th>Prerequisite</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="course_list">
                    <?php 
                        $i = 1;
                        $qry = $conn->query("SELECT c.*, pr.name as program_name, d.name as department, 
                                             (SELECT GROUP_CONCAT(p.catalog_number SEPARATOR ', ') 
                                              FROM `course_list` p 
                                              WHERE FIND_IN_SET(p.id, c.prerequisite)) as prerequisite_course 
                                             FROM `course_list` c 
                                             LEFT JOIN department_list d ON c.department_id = d.id 
                                             LEFT JOIN program_list pr ON c.program_id = pr.id 
                                             WHERE c.`delete_flag` = 0 
                                             ORDER BY c.`catalog_number` ASC ");
                        while($row = $qry->fetch_assoc()):
                    ?>
                        <tr data-program-id="<?= $row['program_id'] ?>" data-course-id="<?= $row['id'] ?>">
                            <td class=""><?php echo $row['catalog_number'] ?></td>
                            <td class=""><?php echo $row['course_title'] ?></td>
                            <td class=""><?php echo $row['credit_unit'] ?></td>
                            <td class=""><?php echo $row['program_name'] ?></td>
                            <td class=""><?php echo $row['prerequisite_course'] ?: '' ?></td>
                            <td align="center">
                                 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                        Action
                                    <span class="sr-only">Toggle Dropdown</span>
                                  </button>
                                  <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item view_data" href="javascript:void(0)" data-id ="<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> View</a>
                                    <?php if($_settings->userdata('type') == 'Administrator'): ?>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item edit_data" href="javascript:void(0)" data-id ="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit Course</a>
                                    <a class="dropdown-item edit_learning_outcome" href="javascript:void(0)" data-id ="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit Learning Outcome</a>
                                    <a class="dropdown-item edit_program_outcome" href="javascript:void(0)" data-id ="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit Program Outcome</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
                                    <?php endif; ?>
                                  </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="uni_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title">Course Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="outcomeTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="course-details-tab" data-toggle="tab" href="#course-details" role="tab" aria-controls="course-details" aria-selected="true">Course Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="learning-outcomes-tab" data-toggle="tab" href="#learning-outcomes" role="tab" aria-controls="learning-outcomes" aria-selected="false">Learning Outcomes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="program-outcomes-tab" data-toggle="tab" href="#program-outcomes" role="tab" aria-controls="program-outcomes" aria-selected="false">Program Outcomes</a>
                    </li>
                </ul>
                <div class="tab-content" id="outcomeTabsContent">
                    <div class="tab-pane fade show active" id="course-details" role="tabpanel" aria-labelledby="course-details-tab">
                        <!-- Course Details Content -->
                    </div>
                    <div class="tab-pane fade" id="learning-outcomes" role="tabpanel" aria-labelledby="learning-outcomes-tab">
                        <!-- Learning Outcomes Content -->
                    </div>
                    <div class="tab-pane fade" id="program-outcomes" role="tabpanel" aria-labelledby="program-outcomes-tab">
                        <!-- Program Outcomes Content -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#create_new').click(function(){
            uni_modal("Add New Course","curriculum/manage_curriculum.php")
        });

        $('#add_learning_outcome').click(function(){
            uni_modal("Add Learning Outcome","curriculum/manage_learning_outcome.php")
        });

        $('#add_program_outcome').click(function(){
            uni_modal("Add Program Outcome","curriculum/add_program_outcome.php")
        });

        $('.view_data').click(function(){
            let id = $(this).attr('data-id');
            uni_modal("View Course Details", "curriculum/view_curriculum.php?id=" + id);
        });

        $('.edit_data').click(function(){
            let id = $(this).attr('data-id');
            uni_modal("Edit Course Detail", "curriculum/manage_curriculum.php?id=" + id);
        });

        $('.edit_learning_outcome').click(function(){
            let id = $(this).attr('data-id');
            uni_modal("Edit Learning Outcome", "curriculum/manage_learning_outcome.php?id=" + id);
        });

        $('.edit_program_outcome').click(function(){
            let id = $(this).attr('data-id');
            uni_modal("Edit Program Outcome", "curriculum/edit_program_outcome.php?id=" + id);
        });

        $('.delete_data').click(function(){
            _conf("Are you sure to delete this Course permanently?", "delete_course", [$(this).attr('data-id')]);
        });

        $('.table td, .table th').addClass('py-1 px-2 align-middle');
        $('.table').dataTable({
            columnDefs: [
                { orderable: false, targets: 5 }
            ],
            lengthChange: false,  // Disable the length change option
            pageLength: 10000     // Set a large number for page length
        });

        $('#course-form').submit(function(e){
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_course",
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function(resp){
                    if(resp.status == 'success'){
                        alert_toast("Course saved successfully", 'success');
                        location.reload();
                    }else{
                        alert_toast(resp.msg || "An error occurred", 'error');
                    }
                },
                error: function(err){
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                }
            });
        });

        $('#program_filter').change(function(){
            var selectedProgram = $(this).val();
            $('#course_list tr').each(function(){
                var row = $(this);
                var programId = row.data('program-id');
                var courseId = row.data('course-id');
                if(selectedProgram === ""){
                    if(courseId >= 1 && courseId <= 4){
                        row.hide();
                    } else {
                        row.show();
                    }
                } else if(selectedProgram == programId){
                    row.show();
                } else {
                    row.hide();
                }
            });
        });

        // Initialize Select2 for prerequisites
        $('.select2').select2({
            placeholder: "Select prerequisites",
            allowClear: true
        });

        // Trigger change event to filter courses by the selected program (BSIT)
        $('#program_filter').trigger('change');
    });

    function delete_course($id){
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_course",
            method: "POST",
            data: { id: $id },
            dataType: "json",
            error: err => {
                console.log(err);
                alert_toast("An error occurred.", 'error');
                end_loader();
            },
            success: function(resp){
                if(typeof resp == 'object' && resp.status == 'success'){
                    location.reload();
                } else {
                    alert_toast("An error occurred.", 'error');
                    end_loader();
                }
            }
        });
    }
</script>
