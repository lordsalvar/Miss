<?php 
if(isset($_GET['id']) && $_GET['id'] > 0){
    $user = $conn->query("SELECT * FROM user where id ='{$_GET['id']}'");
    if($user->num_rows > 0){
        foreach($user->fetch_array() as $k =>$v){
            $meta[$k] = $v;
        }
        if($meta['type'] == 2) {
            $qry = $conn->query("SELECT * FROM `user` WHERE user_id = '{$_GET['id']}'");
            if($qry->num_rows > 0){
                $faculty = $qry->fetch_array();
                foreach($faculty as $k => $v){
                    if(!is_numeric($k))
                    $meta[$k] = $v;
                }
            }
        } elseif($meta['type'] == 3) {
            $qry = $conn->query("SELECT * FROM `user` WHERE user_id = '{$_GET['id']}'");
            if($qry->num_rows > 0){
                $student = $qry->fetch_array();
                foreach($student as $k => $v){
                    if(!is_numeric($k))
                    $meta[$k] = $v;
                }
            }
        }
    }
}
?>
<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
	<div class="card-body">
		<div class="container-fluid">
			<div id="msg"></div>
			<form action="" id="manage-user">	
				<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
				<div class="row">
					<div class="form-group col-md-6">
						<label for="firstname">First Name</label>
						<input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo isset($meta['firstname']) ? $meta['firstname']: '' ?>" required>
					</div>
					<div class="form-group col-md-6">
						<label for="middlename">Middle Name</label>
						<input type="text" name="middlename" id="middlename" class="form-control" value="<?php echo isset($meta['middlename']) ? $meta['middlename']: '' ?>">
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6">
						<label for="lastname">Last Name</label>
						<input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo isset($meta['lastname']) ? $meta['lastname']: '' ?>" required>
					</div>
					<div class="form-group col-md-6">
						<label for="username">Username</label>
						<input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>" required  autocomplete="off">
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6">
						<label for="password">Password</label>
						<input type="password" name="password" id="password" class="form-control" value="" autocomplete="off" <?php echo isset($meta['id']) ? "": 'required' ?>>
						<?php if(isset($_GET['id'])): ?>
						<small class="text-info"><i>Leave this blank if you dont want to change the password.</i></small>
						<?php endif; ?>
					</div>
					<div class="form-group col-md-6">
						<label for="type">User Type</label>
						<select name="type" id="type" class="custom-select" required>
							<option value="Administrator" <?php echo isset($meta['type']) && $meta['type'] == 'Administrator' ? 'selected': '' ?>>Administrator</option>
							<option value="Faculty" <?php echo isset($meta['type']) && $meta['type'] == 'Faculty' ? 'selected': '' ?>>Faculty</option>
							<option value="Student" <?php echo isset($meta['type']) && $meta['type'] == 'Student' ? 'selected': '' ?>>Student</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6">
						<label for="status">Status</label>
						<select name="status" id="status" class="custom-select">
							<option value="0" <?php echo isset($meta['status']) && $meta['status'] == 0 ? 'selected': '' ?>>Inactive</option>
							<option value="1" <?php echo isset($meta['status']) && $meta['status'] == 1 ? 'selected': '' ?>>Active</option>
						</select>
					</div>
					<div class="form-group col-md-6">
						<label for="roll">ID</label>
						<input type="number" name="roll" id="roll" class="form-control" 
       value="<?php echo isset($meta['roll']) ? intval($meta['roll']) : ''; ?>" 
       required min="1" step="1" oninput="validateIntegerInput(this)">
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6">
						<label for="gender">Gender</label>
						<select name="gender" id="gender" class="custom-select">
							<option value="Male" <?php echo isset($meta['gender']) && $meta['gender'] == 'Male' ? 'selected': '' ?>>Male</option>
							<option value="Female" <?php echo isset($meta['gender']) && $meta['gender'] == 'Female' ? 'selected': '' ?>>Female</option>
							<option value="Other" <?php echo isset($meta['gender']) && $meta['gender'] == 'Other' ? 'selected': '' ?>>Other</option>
						</select>
					</div>
					<div class="form-group col-md-6">
						<label for="dob">Date of Birth</label>
						<input type="date" name="dob" id="dob" class="form-control" value="<?php echo isset($meta['dob']) ? $meta['dob']: '' ?>">
					</div>
				</div>
				<div class="row">
				<div class="form-group col-md-6">
				<label for="contact">Contact</label>
				<div class="input-group">
					<span class="input-group-text">+63</span>
					<input type="text" name="contact" id="contact" class="form-control" maxlength="10" pattern="9\d{9}" placeholder="9XX-XXX-XXXX">
				</div>
			</div>
					<div class="form-group col-md-6">
						<label for="address">Address</label>
						<textarea name="address" id="address" class="form-control" maxlength="60" placeholder=""><?php echo isset($meta['address']) ? $meta['address']: '' ?></textarea>
					</div>
				</div>
				<!-- Removed additional fields for Faculty and Student -->
			</form>
		</div>
	</div>
	<div class="card-footer">
			<div class="col-md-12">
				<div class="row">
					<button class="btn btn-sm btn-primary mr-2" form="manage-user">Save</button>
					<a class="btn btn-sm btn-secondary" href="./?page=user/list">Cancel</a>
				</div>
			</div>
		</div>
</div>
<script>
	$(function(){
		$('.select2').select2({
			width:'resolve'
		})
		$('#type').change(function(){
			var type = $(this).val();
			if(type == 2){
				$('#faculty-fields').hide();
				$('#student-fields').hide();
			}else if(type == 3){
				$('#faculty-fields').hide();
				$('#student-fields').hide();
			}else{
				$('#faculty-fields').hide();
				$('#student-fields').hide();
			}
		}).trigger('change');
	})
	$('#manage-user').submit(function(e){
		e.preventDefault();
		var _this = $(this)
		start_loader()
		$.ajax({
			url:_base_url_+'classes/User.php?f=save',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp ==1){
					location.href = './?page=user/list';
				}else{
					$('#msg').html('<div class="alert alert-danger">Username already exist</div>')
					$("html, body").animate({ scrollTop: 0 }, "fast");
				}
                end_loader()
			}
		})
	})
</script>
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
        <!-- Form content will be loaded here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveUserBtn">Save changes</button>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    $('#manageUserModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var userId = button.data('id') // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here.
      var modal = $(this)
      modal.find('.modal-body').load('path/to/form.php?id=' + userId)
    })

    $('#saveUserBtn').click(function() {
      $('#manage-user').submit()
    })
  })
</script>