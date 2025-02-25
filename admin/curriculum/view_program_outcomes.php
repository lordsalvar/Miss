<?php
require_once('../../config.php');
if(isset($_GET['id'])){
    $course_id = $_GET['id'];
    $qry = $conn->query("SELECT `po_code`, `description` FROM `program_outcomes` WHERE `course_id` = '{$course_id}'");
    $program_outcomes = [];
    while($row = $qry->fetch_assoc()){
        $program_outcomes[] = $row;
    }
}
?>
<div class="container-fluid">
    <div class="form-group">
        <label for="course_id" class="control-label">Course</label>
        <div class="pl-4"><?= isset($course_id) ? $course_id : '' ?></div>
    </div>
    <div class="form-group">
        <label for="program_outcomes" class="control-label">Program Outcomes</label>
        <div class="pl-4">
            <ul>
                <?php if(isset($program_outcomes) && count($program_outcomes) > 0): ?>
                    <?php foreach($program_outcomes as $outcome): ?>
                    <li><?= htmlspecialchars($outcome['po_code']) . ': ' . htmlspecialchars($outcome['description']) ?></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>No program outcomes found.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
