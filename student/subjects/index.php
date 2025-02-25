<style>
        .img-thumb-path{
            width:100px;
            height:80px;
            object-fit:scale-down;
            object-position:center center;
        }
    </style>
<body>
    <div class="card card-outline card-primary rounded-0 shadow">
        <div class="card-header">
            <h3 class="card-title">List of Subjects</h3>
            <div class="card-tools">
                <a href="javascript:void(0)" id="create_new" class="btn btn-flat btn-sm btn-primary"><span class="fas fa-plus"></span>  Add New Subject</a>
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
                            <col width="25%">
                            <col width="25%">
                        </colgroup>
                        <thead>
                            <tr class="bg-gradient-dark text-light">
                                <th>#</th>
                                <th>Catalog Number</th>
                                <th>Subject Title</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $i = 1;
                                $qry = $conn->query("SELECT c.*, s.* FROM `course_list` c LEFT JOIN `subject_list` s ON  s.`course_id` = c.`id` where s.`delete_flag` = 0 order by `catalog_number` ");
                                while($row = $qry->fetch_assoc()):
                            ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++; ?></td>
                                    <td class=""><p class="m-0 truncate-1"><?php echo $row['catalog_number'] ?></p></td>
                                    <td class=""><p class="m-0 truncate-1"><?php echo $row['course_title'] ?></p></td>
                                    <td class="text-center">
                                        <?php 
                                            switch ($row['status']){
                                                case 0:
                                                    echo '<span class="rounded-pill badge badge-danger bg-gradient-danger px-3">Inactive</span>';
                                                    break;
                                                case 1:
                                                    echo '<span class="rounded-pill badge badge-success bg-gradient-success px-3">Active</span>';
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
                                            <a class="dropdown-item view_data" href="./?page=subjects/view_subject&id=<?= $row['id'] ?>"><span class="fa fa-eye text-dark"></span> View</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item edit_data" href="./?page=subjects/manage_subject&id=<?= $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
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
        $(document).ready(function(){
            $('#create_new').click(function(){
                window.location.href = "./?page=subjects/manage_subject";
            })
            $('.view_data').click(function(){
                uni_modal("Subject Details","subjects/view_subject.php?id="+$(this).attr('data-id'))
            })
            
            $('.edit_data').click(function () {
                const id = $(this).attr('data-id');
                console.log("Editing ID:", id); // Debug to check the ID being passed
                uni_modal("Update Subject Details", "subjects/manage_subject.php?id=" + id);
            });

            $('.delete_data').click(function(){
                _conf("Are you sure to delete this Subject permanently?","delete_subject",[$(this).attr('data-id')])
            })
            $('.table td, .table th').addClass('py-1 px-2 align-middle')
            $('.table').dataTable({
                columnDefs: [
                { orderable: false, targets: 5 }
                ],
            });
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
                        location.reload();
                    }else{
                        alert_toast("An error occured.",'error');
                        end_loader();
                    }
                }
            })
        }
    </script>
</body>
</html>
