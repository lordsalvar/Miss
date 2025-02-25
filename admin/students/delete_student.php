<?php
require_once('../../config.php');
if(isset($_POST['id'])){
    $id = $_POST['id'];
    $delete_query = "DELETE FROM `user` WHERE id = '$id' AND `type` = 'student'";

    if($conn->query($delete_query)){
        $resp['status'] = 'success';
        $resp['message'] = 'Student deleted successfully';
    } else {
        $resp['status'] = 'failed';
        $resp['message'] = 'Failed to delete student';
    }
} else {
    $resp['status'] = 'failed';
    $resp['message'] = 'Invalid request';
}
echo json_encode($resp);
?>
