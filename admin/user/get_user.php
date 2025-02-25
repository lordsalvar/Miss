<?php
require_once('../../config.php');

$response = ['status' => 'error', 'message' => 'Invalid request.'];

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $qry = $conn->query("SELECT * FROM user WHERE id = '$id'");
    if ($qry->num_rows > 0) {
        $data = $qry->fetch_assoc();
        $data['gender'] = ($data['gender'] == 'Male' || $data['gender'] == 'male') ? 'Male' : 'Female';
        $response = ['status' => 'success', 'data' => $data];
    } else {
        $response['message'] = 'User not found.';
    }
}

echo json_encode($response);
?>
