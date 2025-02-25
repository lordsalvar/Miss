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
    <ul class="nav nav-tabs" id="curriculumTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="course-details-tab" data-toggle="tab" href="#course-details" role="tab" aria-controls="course-details" aria-selected="true">Course Details</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="learning-outcomes-tab" data-toggle="tab" href="#learning-outcomes" role="tab" aria-controls="learning-outcomes" aria-selected="false">Learning Outcomes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="program-outcomes-tab" data-toggle="tab" href="#program-outcomes" role="tab" aria-controls="program-outcomes" aria-selected="false">Program Outcomes</a>
        </li>
    </ul>
    <div class="tab-content" id="curriculumTabsContent">
        <div class="tab-pane fade show active" id="course-details" role="tabpanel" aria-labelledby="course-details-tab">
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
            </div>
            <div class="col-md-6">
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
            </div>
        </div>
        <div class="tab-pane fade" id="learning-outcomes" role="tabpanel" aria-labelledby="learning-outcomes-tab">
            <div class="form-group">
                <label for="learning_outcomes" class="control-label">Learning Outcomes</label>
                <div class="pl-4">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $outcomes = $conn->query("SELECT * FROM `learning_outcomes` WHERE `course_id` = '{$id}'");
                                if($outcomes->num_rows > 0):
                                    while($row = $outcomes->fetch_assoc()):
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['learning_outcome_code']) ?></td>
                                    <td><?= htmlspecialchars($row['learning_outcome']) ?></td>
                                </tr>
                                <?php 
                                    endwhile;
                                else:
                                ?>
                                <tr>
                                    <td colspan="2" class="text-center">No learning outcomes found.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="program-outcomes" role="tabpanel" aria-labelledby="program-outcomes-tab">
            <div class="form-group">
                <label for="program_outcomes" class="control-label">Program Outcomes</label>
                <div class="pl-4">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $program_outcomes = isset($program_outcomes) ? explode(',', $program_outcomes) : [];
                                if(!empty($program_outcomes)):
                                    foreach($program_outcomes as $po_code):
                                        $po_query = $conn->query("SELECT po_code, description FROM `program_outcomes` WHERE `po_code` = '{$po_code}'");
                                        if($po_query->num_rows > 0):
                                            $po_row = $po_query->fetch_assoc();
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($po_row['po_code']) ?></td>
                                    <td><?= htmlspecialchars($po_row['description']) ?></td>
                                </tr>
                                <?php 
                                        endif;
                                    endforeach;
                                else:
                                ?>
                                <tr>
                                    <td colspan="2" class="text-center">No program outcomes found.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>