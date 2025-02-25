<?php
require_once('../../config.php');
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT *, CONCAT(lastname,', ', firstname,' ', middlename) as fullname FROM `student_list` WHERE id = '{$_GET['id']}'");
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
        <label class="control-label text-muted">Student ID</label>
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
        <div class="pl-4"><?= isset($dob) ? date("M d, Y",strtotime($dob)) : 'N/A' ?></div>
    </div>
    <div class="form-group">
        <label class="control-label text-muted">Contact #</label>
        <div class="pl-4"><?= isset($contact) ? $contact : 'N/A' ?></div>
    </div>
    <div class="form-group">
        <label class="control-label text-muted">Present Address</label>
        <div class="pl-4"><?= isset($present_address) ? $present_address : 'N/A' ?></div>
    </div>
    <div class="form-group">
        <label class="control-label text-muted">Permanent Address</label>
        <div class="pl-4"><?= isset($permanent_address) ? $permanent_address : 'N/A' ?></div>
    </div>
    <div class="form-group">
        <label class="control-label text-muted">Year Level</label>
        <div class="pl-4"><?= isset($year_level) ? $year_level : 'N/A' ?></div>
    </div>
    <div class="form-group">
        <label class="control-label text-muted">Program</label>
        <div class="pl-4"><?= isset($program) ? $program : 'N/A' ?></div>
    </div>
</div>
