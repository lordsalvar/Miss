<?php
require_once('../../config.php');

$response = ['status' => 'error', 'message' => 'Invalid request.'];

if (isset($_POST['po_id'])) {
    $po_id = $_POST['po_id'];

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Delete from program_outcomes_igo
        $stmt1 = $conn->prepare("DELETE FROM program_outcomes_igo WHERE po_id = ?");
        $stmt1->bind_param("i", $po_id);
        $stmt1->execute();
        $stmt1->close();

        // Delete from program_outcomes_cpo
        $stmt2 = $conn->prepare("DELETE FROM program_outcomes_cpo WHERE po_id = ?");
        $stmt2->bind_param("i", $po_id);
        $stmt2->execute();
        $stmt2->close();

        // Delete from program_outcomes
        $stmt3 = $conn->prepare("DELETE FROM program_outcomes WHERE po_id = ?");
        $stmt3->bind_param("i", $po_id);
        $stmt3->execute();
        $stmt3->close();

        // Commit transaction
        $conn->commit();

        $response = ['status' => 'success', 'message' => 'Program Outcome and related records deleted successfully.'];
    } catch (Exception $e) {
        // Rollback if any error occurs
        $conn->rollback();
        $response['message'] = "Error: " . $e->getMessage();
    }
}

echo json_encode($response);
?>
