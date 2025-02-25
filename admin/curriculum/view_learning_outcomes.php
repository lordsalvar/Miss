<?php
require_once('../../config.php');
if(isset($_GET['id'])){
    $course_id = $_GET['id'];
    $qry = $conn->query("SELECT * FROM `learning_outcomes` WHERE `course_id` = '{$course_id}'");
    $learning_outcomes = [];
    while($row = $qry->fetch_assoc()){
        $learning_outcomes[] = $row;
    }
}
?>
<div class="container-fluid">
    <div class="form-group">
        <label for="course_id" class="control-label">Course</label>
        <div class="pl-4"><?= isset($course_id) ? $course_id : '' ?></div>
    </div>
    <div class="form-group">
        <label for="learning_outcomes" class="control-label">Learning Outcomes</label>
        <div class="pl-4">
            <ul>
                <?php if(isset($learning_outcomes) && count($learning_outcomes) > 0): ?>
                    <?php foreach($learning_outcomes as $outcome): ?>
                    <li><?= htmlspecialchars($outcome['learning_outcome_code']) . ': ' . htmlspecialchars($outcome['learning_outcome']) ?></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>No learning outcomes found.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
