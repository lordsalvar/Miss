<?php
require_once('../../config.php');

if(isset($_POST['student_id']) && isset($_POST['program']) && isset($_POST['year_level'])){
  $student_id = $_POST['student_id'];
  $program = $_POST['program'];
  $year_level = $_POST['year_level'];

  $sql = "INSERT INTO enrollments (student_id, program_id, year_level) VALUES ('$student_id', '$program', '$year_level')";
  if($conn->query($sql)){
    echo 'success';
  } else {
    echo 'error';
  }
} else {
  echo 'error';
}
?>
