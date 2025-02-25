<?php
$user = $conn->query("SELECT * FROM user where id ='" . $_settings->userdata('id') . "'");
if ($user->num_rows > 0) {
	foreach ($user->fetch_array() as $k => $v) {
		$meta[$k] = $v;
	}
}
?>
<?php if ($_settings->chk_flashdata('success')): ?>
	<script>
		alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
	</script>
<?php endif; ?>
<div class="card card-outline card-primary">
	<div class="card-body">
		<div class="container-fluid">
			<div id="msg"></div>
			<form action="" id="manage-user">
				<!-- <div class="bg-red d-flex flex-col justify-content-around">
					<div class="ali"><h1>dfd</h1></div>
					<div class="bg-green"><h1>dfd</h1></div>
				</div> -->
				<input type="hidden" name="id" value="<?php echo $_settings->userdata('id') ?>">
				<input type="hidden" name="type" value="<?php echo isset($meta['type']) ? $meta['type'] : '' ?>">
				<!-- Automatically set user type -->
				<div class=" d-flex flex-col justify-content-around">
					<div class="w-100 pr-4">
						<div class="form-group">
							<label for="firstname">First Name</label>
							<input type="text" name="firstname" id="firstname" class="form-control"
								value="<?php echo isset($meta['firstname']) ? $meta['firstname'] : '' ?>" required>
							
						</div>
						<div class="form-group">
								<label for="lastname">Last Name</label>
								<input type="text" name="lastname" id="lastname" class="form-control"
									value="<?php echo isset($meta['lastname']) ? $meta['lastname'] : '' ?>" required>
							</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" name="password" id="password" class="form-control" value=""
								autocomplete="off">
							<small><i>Leave this blank if you dont want to change the password.</i></small>
						</div>
						<!-- <div class="form-group">
							<label for="type">Type</label>
							<input type="text" name="type" id="type" class="form-control"
								value="<?php echo isset($meta['type']) ? $meta['type'] : '' ?>">
						</div> -->
						<div class="form-group">
							<label for="type">Type</label>
							<select name="type" id="type" class="form-control">
								<option value="<?php echo isset($meta['type']) ? $meta['type'] : ''; ?>" selected>
									<?php echo isset($meta['type']) ? ucfirst($meta['type']) : 'Select Type'; ?>
								</option>
								<?php if (isset($meta['type']) && $meta['type'] != 'student'): ?>
									<option value="student" <?php echo (isset($meta['type']) && $meta['type'] == 'student') ? 'selected' : ''; ?>>Student</option>
								<?php endif; ?>
								<?php if (isset($meta['type']) && $meta['type'] != 'faculty'): ?>
									<option value="faculty" <?php echo (isset($meta['type']) && $meta['type'] == 'faculty') ? 'selected' : ''; ?>>Faculty</option>
								<?php endif; ?>
								<?php if (isset($meta['type']) && $meta['type'] != 'administrator'): ?>
									<option value="administrator" <?php echo (isset($meta['type']) && $meta['type'] == 'administrator') ? 'selected' : ''; ?>>Administrator</option>
								<?php endif; ?>
							</select>
						</div>



						<!-- <div class="form-group">
							<label for="roll">Roll</label>
							<input type="text" name="roll" id="roll" class="form-control"
								value="<?php echo isset($meta['roll']) ? $meta['roll'] : '' ?>">
						</div> -->
						<div class="form-group"	>
							<label for="dob">Date of Birth</label>
							<input type="date" name="dob" id="dob" class="form-control"
								value="<?php echo isset($meta['dob']) ? $meta['dob'] : '' ?>">
						</div>
					</div>
					<div class="w-100">
						<div class="form-group">
							<label for="middlename">Middle Name</label>
							<input type="text" name="middlename" id="middlename" class="form-control"
								value="<?php echo isset($meta['middlename']) ? $meta['middlename'] : '' ?>">
						</div>
						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" name="username" id="username" class="form-control"
								value="<?php echo isset($meta['username']) ? $meta['username'] : '' ?>" required
								autocomplete="off">
						</div>

						<div class="form-group">
							<label for="status">Status</label>
							<select name="status" id="status" class="custom-select" required>
								<option value="0" <?php echo isset($meta['status']) && $meta['status'] == 0 ? 'selected' : '' ?>>
									Inactive</option>
								<option value="1" <?php echo isset($meta['status']) && $meta['status'] == 1 ? 'selected' : '' ?>>
									Active</option>
							</select>
						</div>
						<div class="form-group">
							<label for="gender">Gender</label>
							<select name="gender" id="gender" class="custom-select" required>
								<option value="male" <?php echo isset($meta['gender']) && $meta['gender'] == 'male' ? 'selected' : '' ?>>Male</option>
								<option value="female" <?php echo isset($meta['gender']) && $meta['gender'] == 'female' ? 'selected' : '' ?>>Female</option>
								<option value="other" <?php echo isset($meta['gender']) && $meta['gender'] == 'other' ? 'selected' : '' ?>>Other</option>
							</select>
						</div>
						<div class="form-group">
					<label for="contact">Contact</label>
					<input type="text" name="contact" id="contact" class="form-control"
						value="<?php echo isset($meta['contact']) ? $meta['contact'] : '' ?>">
				</div>
					</div>
				</div>				
				<div class="form-group">
					<label for="address">Address</label>
					<textarea name="address" id="address"
						class="form-control"><?php echo isset($meta['address']) ? $meta['address'] : '' ?></textarea>
				</div>
				<!-- Removed avatar input and image display section -->
			</form>
		</div>
	</div>
	<div class="card-footer">
		<div class="col-md-12">
			<div class="row">
				<button class="btn btn-sm btn-primary" form="manage-user">Update</button>
			</div>
		</div>
	</div>
</div>
<script>
	$('#manage-user').submit(function (e) {
		e.preventDefault();
		var _this = $(this)
		start_loader()
		$.ajax({
			url: _base_url_ + 'classes/User.php?f=update_user',
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success: function (resp) {
				if (resp == 1) {
					alert_toast("User data updated successfully.", 'success');
					setTimeout(function () {
						location.reload();
					}, 1500);
				} else if (resp == 2) {
					$('#msg').html('<div class="alert alert-danger">Username already exists.</div>')
					end_loader()
				} else {
					$('#msg').html('<div class="alert alert-danger">An error occurred.</div>')
					end_loader()
				}
			},
			error: function (err) {
				console.log(err);
				alert_toast("An error occurred.", 'error');
				end_loader();
			}
		})
	})
	function validateYear(input) {
        // Allow only numbers and restrict to 4 digits in the year
        input.value = input.value.replace(/[^0-9\-]/g, ''); // Remove non-numeric and non-dash characters
        const parts = input.value.split('-');
        if (parts.length > 1) {
            parts[0] = parts[0].substring(0, 4); // Limit year to 4 digits
        }
        input.value = parts.join('-');
    }
</script>