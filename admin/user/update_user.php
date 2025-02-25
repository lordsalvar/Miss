<?php
require_once('../../config.php');

$response = ['status' => 'error', 'message' => 'An error occurred.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = !empty($_POST['password']) ? md5($_POST['password']) : null;
    $type = $_POST['type'];
    $status = $_POST['status'];
    $roll = $_POST['roll'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];

    $query = "UPDATE user SET firstname = ?, middlename = ?, lastname = ?, username = ?, type = ?, status = ?, roll = ?, gender = ?, dob = ?, contact = ?, address = ?";
    $params = [$firstname, $middlename, $lastname, $username, $type, $status, $roll, $gender, $dob, $contact, $address];

    if ($password) {
        $query .= ", password = ?";
        $params[] = $password;
    }

    $query .= " WHERE id = ?";
    $params[] = $id;

    $stmt = $conn->prepare($query);
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);

    if ($stmt->execute()) {
        $response = ['status' => 'success', 'message' => 'User updated successfully.'];
    } else {
        $response['message'] = "Error: " . $stmt->error;
    }

    $stmt->close();
}

echo json_encode($response);
?>
