<?php
require_once('../../config.php');
if(isset($_POST['id'])){
    $id = $_POST['id'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : '';
    $type = $_POST['type'];
    $status = $_POST['status'];
    $roll = $_POST['roll'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];

    $update_query = "UPDATE `user` SET 
        firstname = '$firstname', 
        middlename = '$middlename', 
        lastname = '$lastname', 
        username = '$username', 
        type = '$type', 
        status = '$status', 
        roll = '$roll', 
        gender = '$gender', 
        dob = '$dob', 
        contact = '$contact', 
        address = '$address'";

    if(!empty($password)){
        $update_query .= ", password = '$password'";
    }

    $update_query .= " WHERE id = '$id'";

    if($conn->query($update_query)){
        $resp['status'] = 'success';
    } else {
        $resp['status'] = 'failed';
        $resp['message'] = 'Failed to update student data';
    }
} else {
    $resp['status'] = 'failed';
    $resp['message'] = 'Invalid request';
}
echo json_encode($resp);
?>
