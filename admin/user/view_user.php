<?php
require_once('../../config.php');
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT *, CONCAT(firstname, ' ', IFNULL(CONCAT(middlename, '.'), ''), ' ', lastname) as fullname FROM `user` WHERE id = '{$_GET['id']}'");
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
    <div class="form-group">
        <label class="control-label text-muted">User ID</label>
        <div class="pl-4"><?= isset($roll) ? $roll : 'N/A' ?></div>
    </div>
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
        <label class="control-label text-muted">Name</label>
        <div class="pl-4"><?= isset($fullname) ? $fullname : 'N/A' ?></div>
    </div>
    <div class="form-group">
        <label class="control-label text-muted">Gender</label>
        <div class="pl-4"><?= isset($gender) ? ucfirst($gender) : 'N/A' ?></div>
    </div>
    <div class="form-group">
        <label class="control-label text-muted">Date of Birth</label>
        <div class="pl-4"><?= isset($dob) && !empty($dob) && $dob != '0000-00-00' ? date("M d, Y", strtotime($dob)) : 'N/A' ?></div>
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
