<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of System Users</h3>
		<div class="card-tools">
			<a href="?page=user/manage_user" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Create New</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<div class="form-group">
				<label for="user_type_filter" class="control-label">Filter by User Type</label>
				<select id="user_type_filter" class="form-control form-control-sm">
					<option value="">All Users</option>
					<option value="Administrator">Administrator</option>
					<option value="Faculty">Faculty</option>
					<option value="Student">Student</option>
				</select>
			</div>
			<table class="table table-hover table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Username</th>
						<th>User Type</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody id="user_list">
					<?php 
						$i = 1;
						$qry = $conn->query("SELECT *, CONCAT(firstname, ' ', IFNULL(CONCAT(middlename, '.'), ''), ' ', lastname) as name FROM `user` ORDER BY CONCAT(firstname, ' ', IFNULL(CONCAT(middlename, '.'), ''), ' ', lastname) ASC");
						while($row = $qry->fetch_assoc()):
					?>
						<tr data-user-type="<?= $row['type'] ?>">
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo ucwords($row['name']) ?></td>
							<td ><p class="m-0 truncate-1"><?php echo $row['username'] ?></p></td>
							<td ><p class="m-0">
								<?php 
									switch($row['type']) {
										case 'Administrator':
											echo "Administrator";
											break;
										case 'Faculty':
											echo "Faculty";
											break;
										case 'Student':
											echo "Student";
											break;
										default:
											echo "Unknown";
											break;
									}
								?>
							</p></td>
							<td align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> View</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
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

<!-- Modal for managing user data -->
<div class="modal fade" id="manageUserModal" tabindex="-1" role="dialog" aria-labelledby="manageUserModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="manageUserModalLabel">Manage User</h5>
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
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
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

<!-- Modal for viewing user data -->
<div class="modal fade" id="viewUserModal" tabindex="-1" role="dialog" aria-labelledby="viewUserModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewUserModalLabel">User Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="user-details-content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this User permanently?","delete_user",[$(this).attr('data-id')])
		})
		$('.table td,.table th').addClass('py-1 px-2 align-middle')
		$('.table').dataTable();
		$('.edit_data').click(function(){
			var id = $(this).attr('data-id');
			$.ajax({
				url: _base_url_ + 'admin/user/get_user.php',
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
						$('#manage-user').attr('action', _base_url_ + 'admin/user/update_user.php');
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
				url: _base_url_ + 'admin/user/view_user.php',
				method: 'GET',
				data: { id: id },
				success: function(resp){
					$('#user-details-content').html(resp);
					$('#viewUserModal').modal('show');
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
				url: _base_url_ + 'admin/user/update_user.php',
				method: 'POST',
				data: new FormData(_this[0]),
				cache: false,
				contentType: false,
				processData: false,
				dataType: 'json',
				success: function(resp){
					if(resp.status == 'success'){
						alert_toast("User updated successfully.", 'success');
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

		$('#user_type_filter').change(function(){
			var selectedType = $(this).val();
			$('#user_list tr').each(function(){
				var row = $(this);
				var userType = row.data('user-type');
				if(selectedType === "" || selectedType == userType){
					row.show();
				} else {
					row.hide();
				}
			});
		});
	})

	function delete_user(id){
		start_loader();
		$.ajax({
			url: _base_url_ + "admin/user/delete_user.php",
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
					alert_toast("User deleted successfully.", 'success');
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