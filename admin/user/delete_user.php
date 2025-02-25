<?php
require_once('../../config.php');

$response = ['status' => 'error', 'message' => 'Invalid request.'];

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM user WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $response = ['status' => 'success', 'message' => 'User deleted successfully.'];
    } else {
        $response['message'] = "Error: " . $stmt->error;
    }

    $stmt->close();
}

echo json_encode($response);
?>
