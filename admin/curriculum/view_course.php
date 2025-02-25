<?php
require_once('../../config.php');
if(isset($_GET['id'])){
    $id = $_GET['id']; // Ensure $id is set
    $qry = $conn->query("SELECT c.*, d.name as department, p.catalog_number as prerequisite_catalog, p.course_title as prerequisite_title, pr.name as program_name FROM `course_list` c LEFT JOIN department_list d ON c.department_id = d.id LEFT JOIN course_list p ON c.prerequisite = p.id LEFT JOIN program_list pr ON c.program_id = pr.id WHERE c.id = '{$id}'");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k = $v;
        }
    }
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="catalog_number" class="control-label">Catalog Number</label>
                <div class="pl-4"><?= isset($catalog_number) ? $catalog_number : '' ?></div>
            </div>
            <div class="form-group">
                <label for="course_title" class="control-label">Course Title</label>
                <div class="pl-4"><?= isset($course_title) ? $course_title : '' ?></div>
            </div>
            <div class="form-group">
                <label for="credit_unit" class="control-label">Credit Unit</label>
                <div class="pl-4"><?= isset($credit_unit) ? $credit_unit : '' ?></div>
            </div>
            <div class="form-group">
                <label for="semester" class="control-label">Semester</label>
                <div class="pl-4"><?= isset($semester) ? $semester : '' ?></div>
            </div>
            <div class="form-group">
                <label for="year_level" class="control-label">Year Level</label>
                <div class="pl-4"><?= isset($year_level) ? $year_level : '' ?></div>
            </div>
            <div class="form-group">
                <label for="program" class="control-label">Program</label>
                <div class="pl-4"><?= isset($program_name) ? $program_name : '' ?></div>
            </div>
            <div class="form-group">
                <label for="prerequisite" class="control-label">Prerequisite</label>
                <div class="pl-4"><?= isset($prerequisite_catalog) ? $prerequisite_catalog . ' - ' . $prerequisite_title : 'None' ?></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="learning_outcomes" class="control-label">Learning Outcomes</label>
                <div class="pl-4">
                    <ul>
                        <?php
                        $outcomes = $conn->query("SELECT * FROM `learning_outcomes` WHERE `course_id` = '{$id}'");
                        while($row = $outcomes->fetch_assoc()):
                        ?>
                        <li><?= $row['learning_outcome_code'] . ': ' . $row['learning_outcome'] ?></li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
            <div class="form-group">
                <label for="program_outcomes" class="control-label">Program Outcomes</label>
                <div class="pl-4">
                    <ul>
                        <?php
                        $outcomes = $conn->query("SELECT * FROM `program_outcomes` WHERE `course_id` = '{$id}'");
                        while($row = $outcomes->fetch_assoc()):
                        ?>
                        <li><?= $row['po_code'] . ': ' . $row['description'] ?></li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
