<?php
require_once('../../config.php');
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `student_list` WHERE id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
    }
}
?>
<div class="container-fluid">
    <form action="" id="edit_student_form">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div class="form-group">
            <label for="roll" class="control-label">Student ID</label>
            <input type="text" name="roll" id="roll" value="<?= isset($roll) ? $roll : "" ?>" class="form-control form-control-sm rounded-0" required>
        </div>
        <div class="form-group">
            <label for="firstname" class="control-label">First Name</label>
            <input type="text" name="firstname" id="firstname" value="<?= isset($firstname) ? $firstname : "" ?>" class="form-control form-control-sm rounded-0" required>
        </div>
        <div class="form-group">
            <label for="middlename" class="control-label">Middle Name</label>
            <input type="text" name="middlename" id="middlename" value="<?= isset($middlename) ? $middlename : "" ?>" class="form-control form-control-sm rounded-0" placeholder="optional">
        </div>
        <div class="form-group">
            <label for="lastname" class="control-label">Last Name</label>
            <input type="text" name="lastname" id="lastname" value="<?= isset($lastname) ? $lastname : "" ?>" class="form-control form-control-sm rounded-0" required>
        </div>
        <div class="form-group">
            <label for="dob" class="control-label">Date of Birth</label>
            <input type="date" name="dob" id="dob" value="<?= isset($dob) ? $dob : "" ?>" class="form-control form-control-sm rounded-0" required>
        </div>
        <div class="form-group">
            <label for="gender" class="control-label">Gender</label>
            <select name="gender" id="gender" class="form-control form-control-sm rounded-0" required>
                <option value="Male" <?= isset($gender) && $gender == 'Male' ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?= isset($gender) && $gender == 'Female' ? 'selected' : '' ?>>Female</option>
            </select>
        </div>
        <div class="form-group">
            <label for="address" class="control-label">Address</label>
            <textarea name="address" id="address" class="form-control form-control-sm rounded-0" required><?= isset($address) ? $address : "" ?></textarea>
        </div>
        <div class="form-group">
            <label for="contact" class="control-label">Contact</label>
            <input type="text" name="contact" id="contact" value="<?= isset($contact) ? $contact : "" ?>" class="form-control form-control-sm rounded-0" required>
        </div>
    </form>
</div>
