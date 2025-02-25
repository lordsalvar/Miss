<?php
require_once('../../config.php'); // Include the database configuration file
?>

<style>
    .img-thumb-path {
        width: 100px;
        height: 80px;
        object-fit: scale-down;
        object-position: center center;
    }
</style>
<div class="card card-outline card-primary rounded-0 shadow">
    <div class="card-header">
        <h3 class="card-title">List of students</h3>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="container-fluid">
                <table class="table table-bordered table-hover table-striped">
                    <colgroup>
                        <col width="5%">
                        <col width="20%">
                        <col width="20%">
                        <col width="25%">
                        <col width="15%">
                        <col width="15%">
                    </colgroup>
                    <thead>
                        <tr class="bg-gradient-dark text-light">
                            <th>#</th>
                            <th>Date Created</th>
                            <th>Roll</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1;

                        $qry = $conn->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as fullname from `student_list` order by concat(lastname,', ',firstname,' ',middlename) asc ");
                        while($row = $qry->fetch_assoc()):
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $i++; ?></td>
                            <td class=""><?php echo date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>
                            <td class="">
                                <p class="m-0 truncate-1"><?php echo $row['roll'] ?></p>
                            </td>
                            <td class="">
                                <p class="m-0 truncate-1"><?php echo $row['fullname'] ?></p>
                            </td>
                            <td class="text-center">
                                <?php 
                                switch ($row['status']) {
                                    case 0:
                                        echo '<span class="rounded-pill badge badge-danger bg-gradient-danger px-3">Removed</span>';
                                        break;
                                    case 1:
                                        echo '<span class="rounded-pill badge badge-success bg-gradient-success px-3">Added</span>';
                                        break;
                                }
                                ?>
                            </td>
                            <td align="center">
                                <div class="dropdown">
                                    <button class="btn btn-flat btn-primary btn-sm border dropdown-toggle" type="button" id="actionDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="actionDropdown">
                                        <a class="dropdown-item add_student" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><i class="fa fa-plus"></i> Add</a>
                                        <a class="dropdown-item remove_student" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><i class="fa fa-trash"></i> Remove</a>
                                    </div>
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
<script>
    $(document).ready(function () {
        $('.table td, .table th').addClass('py-1 px-2 align-middle');
        $('.table').dataTable({
            columnDefs: [
                { orderable: false, targets: 5 }
            ],
        });
        $('.add_student').click(function(){
            add_student($(this).attr('data-id'));
        })
        $('.remove_student').click(function(){
            delete_student($(this).attr('data-id'));
        })
    });

    function delete_student($id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_student",
            method: "POST",
            data: { id: $id },
            dataType: "json",
            error: err => {
                console.log(err);
                alert_toast("An error occured.", 'error');
                end_loader();
            },
            success: function (resp) {
                if (typeof resp == 'object' && resp.status == 'success') {
                    location.reload();
                } else {
                    alert_toast("An error occured.", 'error');
                    end_loader();
                }
            }
        });
    }

    function add_student($id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=add_student",
            method: "POST",
            data: { faculty_id: '<?= isset($_GET['faculty_id']) ? $_GET['faculty_id'] : '' ?>', student_id: $id },
            dataType: "json",
            error: err => {
                console.log(err);
                alert_toast("An error occured.", 'error');
                end_loader();
            },
            success: function (resp) {
                if (typeof resp == 'object' && resp.status == 'success') {
                    location.reload();
                } else {
                    alert_toast("An error occured.", 'error');
                    end_loader();
                }
            }
        });
    }
</script>
