<?php
require_once('../../config.php');
if(isset($_POST['id'])){
    $qry = $conn->query("SELECT * FROM `user` WHERE id = '{$_POST['id']}' AND `type` = 'student'");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        $data = array();
        foreach($res as $k => $v){
            if(!is_numeric($k))
            $data[$k] = $v;
        }
        $resp['status'] = 'success';
        $resp['data'] = $data;
    } else {
        $resp['status'] = 'failed';
        $resp['message'] = 'Student not found';
    }
} else {
    $resp['status'] = 'failed';
    $resp['message'] = 'Invalid request';
}
echo json_encode($resp);
?>
