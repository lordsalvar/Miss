<?php
// Debug statement to check if the script is being executed
error_log("Script executed: " . __FILE__);

// require_once('../../config.php');

// Debug statement to check if the config file is included
error_log("Config file included");

?>
<style>
    .img-thumb-path {
        width: 100px;
        height: 80px;
        object-fit: scale-down;
        object-position: center center;
    }
    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1) !important;
    }
    .card-header {
        background: linear-gradient(135deg, #1a237e 0%, #121858 100%);
        color: white;
        border-radius: 15px 15px 0 0 !important;
        padding: 1.5rem;
    }
    .card-title {
        font-size: 1.5rem;
        font-weight: 600;
    }
    .btn-primary {
        background: linear-gradient(135deg, #1a237e 0%, #121858 100%);
        border: none;
        border-radius: 50px;
        padding: 0.5rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    .table {
        margin-top: 1rem;
    }
    .table thead th {
        background: #f8f9fa;
        color: #333;
        font-weight: 600;
        border: none;
        padding: 1rem;
    }
    .table td {
        vertical-align: middle;
        padding: 1rem;
        border-color: #f8f9fa;
    }
    .table tbody tr {
        transition: all 0.3s ease;
    }
    .table tbody tr:hover {
        background: rgba(26, 35, 126, 0.05);
        transform: translateY(-2px);
    }
    .badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 500;
    }
    .badge-success {
        background: #28a745;
        color: white;
    }
    .badge-danger {
        background: #dc3545;
        color: white;
    }
    .dropdown-menu {
        border: none;
        box-shadow: 0 5px 25px rgba(0,0,0,0.1);
        border-radius: 15px;
        padding: 1rem 0;
    }
    .dropdown-item {
        padding: 0.7rem 1.5rem;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .dropdown-item:hover {
        background: rgba(26, 35, 126, 0.05);
        transform: translateX(5px);
    }
    .btn-default {
        border-radius: 50px;
        padding: 0.5rem 1rem;
        transition: all 0.3s ease;
    }
    .search-box {
        border-radius: 50px;
        padding: 0.5rem 1rem;
        border: 1px solid #ddd;
        margin-bottom: 1rem;
    }
</style>
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h3 class="card-title mb-0">List of Students</h3>
            <div>
                <a href="./?page=user/manage_user" class="btn btn-primary">
                    <i class="fas fa-plus mr-2"></i>Add New Student
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="container-fluid">
                <table class="table table-bordered table-hover table-striped">
                    <colgroup>
                        <col width="5%">
                        <col width="20%">
                        <col width="25%">
                        <col width="15%">
                        <col width="15%">
                    </colgroup>
                    <thead>
                        <tr class="bg-gradient-dark text-light">
                            <th>#</th>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $i = 1;
                            $qry = $conn->query("SELECT id, roll, firstname, middlename, lastname, status FROM `user` WHERE `type` = 'student' ORDER BY lastname ASC, firstname ASC");
                            while($row = $qry->fetch_assoc()):
                                $fullname = $row['lastname'] . ', ' . $row['firstname'] . ' ' . $row['middlename'];
                                $status = isset($row['status']) ? $row['status'] : 'N/A';
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $i++; ?></td>
                                <td class=""><p class="m-0 truncate-1"><?php echo $row['roll'] ?></p></td>
                                <td class=""><p class="m-0 truncate-1"><?php echo $fullname ?></p></td>
                                <td class="text-center">
                                    <?php 
                                        switch ($status) {
                                            case 0:
                                                echo '<span class="rounded-pill badge badge-danger bg-gradient-danger px-3">Inactive</span>';
                                                break;
                                            case 1:
                                                echo '<span class="rounded-pill badge badge-success bg-gradient-success px-3">Active</span>';
                                                break;
                                            default:
                                                echo '<span class="rounded-pill badge badge-secondary bg-gradient-secondary px-3">Unknown</span>';
                                                break;
                                        }
                                    ?>
                                </td>
                                <td align="center">
                                    <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                        Action
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                        <a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?= $row['id'] ?>"><span class="fa fa-eye text-dark"></span> View</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?= $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?= $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
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

<!-- Modal for managing student data -->
<div class="modal fade" id="manageUserModal" tabindex="-1" role="dialog" aria-labelledby="manageUserModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="manageUserModalLabel">Manage Student</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" id="manage-user">
            <input type="hidden" name="id">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="firstname">First Name</label>
                    <input type="text" name="firstname" id="firstname" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="middlename">Middle Name</label>
                    <input type="text" name="middlename" id="middlename" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="lastname">Last Name</label>
                    <input type="text" name="lastname" id="lastname" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control" required autocomplete="off">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" autocomplete="off">
                    <small class="text-info"><i>Leave this blank if you don't want to change the password.</i></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="type">User Type</label>
                    <select name="type" id="type" class="custom-select" required>
                        <option value="Administrator">Administrator</option>
                        <option value="Faculty">Faculty</option>
                        <option value="Student">Student</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="custom-select">
                        <option value="0">Inactive</option>
                        <option value="1">Active</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="roll">ID</label>
                    <input type="text" name="roll" id="roll" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender" class="custom-select">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="dob">Date of Birth</label>
                    <input type="date" name="dob" id="dob" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="contact">Contact</label>
                    <input type="text" name="contact" id="contact" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label for="address">Address</label>
                    <textarea name="address" id="address" class="form-control"></textarea>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveUserBtn">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal for viewing student data -->
<div class="modal fade" id="viewStudentModal" tabindex="-1" role="dialog" aria-labelledby="viewStudentModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewStudentModalLabel">Student Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="student-details-content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function(){
        $('.table td, .table th').addClass('py-1 px-2 align-middle');
        // Initialize DataTable with enhanced styling
        var table = $('.table').DataTable({
            "dom": '<"row"<"col-md-12"f>>rt', // Remove pagination ('p') and info ('i')
            pageLength: -1, // Show all records
            ordering: true,
            responsive: true,
            language: {
                searchPlaceholder: "Search students...",
                info: "",
                infoEmpty: "",
                infoFiltered: "",
                paginate: false // Disable pagination text
            },
            columnDefs: [
                { orderable: false, targets: 4 }
            ],
        });

        // Add animation to delete confirmation
        $('.delete_data').click(function(){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1a237e',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    delete_student($(this).attr('data-id'));
                }
            });
        });

        $('.edit_data').click(function(){
            var id = $(this).attr('data-id');
            $.ajax({
                url: _base_url_ + 'admin/students/get_student.php',
                method: 'POST',
                data: { id: id },
                dataType: 'json',
                success: function(resp){
                    if(resp.status == 'success'){
                        var data = resp.data;
                        $('#manage-user [name="id"]').val(data.id);
                        $('#manage-user [name="firstname"]').val(data.firstname);
                        $('#manage-user [name="middlename"]').val(data.middlename);
                        $('#manage-user [name="lastname"]').val(data.lastname);
                        $('#manage-user [name="username"]').val(data.username);
                        $('#manage-user [name="type"]').val(data.type);
                        $('#manage-user [name="status"]').val(data.status);
                        $('#manage-user [name="roll"]').val(data.roll);
                        $('#manage-user [name="gender"]').val(data.gender);
                        $('#manage-user [name="dob"]').val(data.dob);
                        $('#manage-user [name="contact"]').val(data.contact);
                        $('#manage-user [name="address"]').val(data.address);
                        $('#manage-user').attr('action', _base_url_ + 'admin/students/update_student.php');
                        $('#manageUserModal').modal('show');
                    }else{
                        alert_toast(resp.message, 'error');
                    }
                },
                error: function(err){
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                }
            });
        });

        $('.view_data').click(function(){
            var id = $(this).attr('data-id');
            $.ajax({
                url: _base_url_ + 'admin/students/view_student.php',
                method: 'GET',
                data: { id: id },
                success: function(resp){
                    $('#student-details-content').html(resp);
                    $('#viewStudentModal').modal('show');
                },
                error: function(err){
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                }
            });
        });

        $('#saveUserBtn').click(function(){
            $('#manage-user').submit();
        });

        $('#manage-user').submit(function(e){
            e.preventDefault();
            var _this = $(this);
            start_loader();
            $.ajax({
                url: _base_url_ + 'admin/students/update_student.php',
                method: 'POST',
                data: new FormData(_this[0]),
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(resp){
                    if(resp.status == 'success'){
                        alert_toast("Student updated successfully.", 'success');
                        setTimeout(function(){
                            location.reload();
                        }, 1500);
                    }else{
                        alert_toast(resp.message, 'error');
                        end_loader();
                    }
                },
                error: function(err){
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                    end_loader();
                }
            });
        });
    });

    function delete_student(id){
        start_loader();
        $.ajax({
            url: _base_url_ + "admin/students/delete_student.php",
            method: "POST",
            data: { id: id },
            dataType: "json",
            error: err => {
                console.log(err);
                alert_toast("An error occurred.", 'error');
                end_loader();
            },
            success: function(resp){
                if (typeof resp == 'object' && resp.status == 'success') {
                    alert_toast("Student deleted successfully.", 'success');
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                } else {
                    alert_toast("An error occurred.", 'error');
                    end_loader();
                }
            }
        });
    }
</script>