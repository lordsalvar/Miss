<?php
require_once('../../config.php');

$response = ['status' => 'error', 'message' => 'An error occurred.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $po_code = $_POST['po_code'];
    $graduate_attribute_id = $_POST['graduate_attribute']; // Foreign key
    $description = $_POST['description'];
    $performance_indicator = $_POST['performance_indicator'];
    $program_id = $_POST['course_id'];  // Foreign key from program_list
    $igos = isset($_POST['igo']) ? $_POST['igo'] : [];
    $cpos = isset($_POST['cpo']) ? $_POST['cpo'] : [];

    // Debugging output
    error_log("po_code: $po_code");
    error_log("graduate_attribute_id: $graduate_attribute_id");
    error_log("description: $description");
    error_log("performance_indicator: $performance_indicator");
    error_log("program_id: $program_id");
    error_log("igos: " . implode(", ", $igos));
    error_log("cpos: " . implode(", ", $cpos));

    // Insert into program_outcomes table (with graduate_attribute_id)
    $stmt = $conn->prepare("INSERT INTO program_outcomes (program_id, po_code, graduate_attribute_id, description, performance_indicator) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isiss", $program_id, $po_code, $graduate_attribute_id, $description, $performance_indicator);

    if ($stmt->execute()) {
        $po_id = $stmt->insert_id; // Get the last inserted ID

        // Insert into program_outcomes_igo (mapping table)
        if (!empty($igos)) {
            $igo_stmt = $conn->prepare("INSERT INTO program_outcomes_igo (po_id, igo_id) VALUES (?, ?)");
            foreach ($igos as $igo_id) {
                $igo_stmt->bind_param("ii", $po_id, $igo_id);
                $igo_stmt->execute();
            }
            $igo_stmt->close();
        }

        // Insert into program_outcomes_cpo (mapping table)
        if (!empty($cpos)) {
            $cpo_stmt = $conn->prepare("INSERT INTO program_outcomes_cpo (po_id, cpo_id) VALUES (?, ?)");
            foreach ($cpos as $cpo_id) {
                $cpo_stmt->bind_param("ii", $po_id, $cpo_id);
                $cpo_stmt->execute();
            }
            $cpo_stmt->close();
        }

        $response = ['status' => 'success', 'message' => 'Program Outcome added successfully.'];
    } else {
        $response['message'] = "Error: " . $stmt->error;
    }

    $stmt->close();
}

echo json_encode($response);
?>
