<?php
require_once('../../config.php');

$response = ['status' => 'error', 'message' => 'An error occurred.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $po_id = $_POST['po_id'];
    $po_code = $_POST['po_code'];
    $graduate_attribute_id = $_POST['graduate_attribute']; // Foreign key
    $description = $_POST['description'];
    $performance_indicator = $_POST['performance_indicator'];
    $program_id = $_POST['course_id'];  // Foreign key from program_list
    $igos = isset($_POST['igo']) ? $_POST['igo'] : [];
    $cpos = isset($_POST['cpo']) ? $_POST['cpo'] : [];

    // Update program_outcomes table
    $stmt = $conn->prepare("UPDATE program_outcomes SET program_id = ?, po_code = ?, graduate_attribute_id = ?, description = ?, performance_indicator = ? WHERE po_id = ?");
    $stmt->bind_param("isissi", $program_id, $po_code, $graduate_attribute_id, $description, $performance_indicator, $po_id);

    if ($stmt->execute()) {
        // Delete existing mappings
        $conn->query("DELETE FROM program_outcomes_igo WHERE po_id = '$po_id'");
        $conn->query("DELETE FROM program_outcomes_cpo WHERE po_id = '$po_id'");

        // Insert new IGO mappings
        if (!empty($igos)) {
            $igo_stmt = $conn->prepare("INSERT INTO program_outcomes_igo (po_id, igo_id) VALUES (?, ?)");
            foreach ($igos as $igo_id) {
                $igo_stmt->bind_param("ii", $po_id, $igo_id);
                $igo_stmt->execute();
            }
            $igo_stmt->close();
        }

        // Insert new CPO mappings
        if (!empty($cpos)) {
            $cpo_stmt = $conn->prepare("INSERT INTO program_outcomes_cpo (po_id, cpo_id) VALUES (?, ?)");
            foreach ($cpos as $cpo_id) {
                $cpo_stmt->bind_param("ii", $po_id, $cpo_id);
                $cpo_stmt->execute();
            }
            $cpo_stmt->close();
        }

        $response = ['status' => 'success', 'message' => 'Program Outcome updated successfully.'];
    } else {
        $response['message'] = "Error: " . $stmt->error;
    }

    $stmt->close();
}

echo json_encode($response);
?>
