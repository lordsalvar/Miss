<?php
require_once('../../config.php');
if(isset($_GET['program_id'])){
    $program_id = $_GET['program_id'];
    $qry = $conn->query("SELECT id, catalog_number, course_title FROM `course_list` WHERE program_id = '$program_id' ORDER BY catalog_number ASC");
    $courses = [];
    while($row = $qry->fetch_assoc()){
        $courses[] = $row;
    }
    $resp['status'] = 'success';
    $resp['data'] = $courses;
} else {
    $resp['status'] = 'failed';
    $resp['message'] = 'Invalid request';
}
echo json_encode($resp);
?>
