<?php
// Assuming you have a database connection in $conn
var_dump($_GET);
// Check if 'id' is passed in the URL
if (isset($_GET['id'])) {
    // Perform the query to get subject details
    // s. subject_list
    // c. course_list
    $qry = $conn->query("SELECT s.course_title, c.catalog_number 
                     FROM `subject_list` s 
                     LEFT JOIN `course_list` c ON s.course_id = c.id 
                     WHERE s.id = '{$_GET['subject_id']}'");


    // Check if any data is returned
    if ($qry->num_rows > 0) {
        // Fetch the result
        $res = $qry->fetch_array();
        // Set the variables for course title and catalog number
        $course_title = $res['course_title'];
        $catalog_number = $res['catalog_number'];
    } else {
        // Set to 'N/A' if no result is found
        $course_title = 'N/A';
        $catalog_number = 'N/A';
    }
} else {
    // Set to 'N/A' if 'id' is not provided
    $course_title = 'no course title';
    $catalog_number = 'no catalog number';
}

// Get the 'id' from the URL
$id = isset($_GET['id']) ? $_GET['id'] : 'no ID';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject Details</title>
</head>
<body>
    <div class="container">
        <h1>Subject ID: <?php echo $id; ?></h1> <!-- Display ID -->
        <h2>Subject Title: <?php echo $course_title; ?></h2> <!-- Display Course Title -->
        <p>Catalog Number: <?php echo $catalog_number; ?></p> <!-- Display Catalog Number -->
    </div>
</body>
</html>
