<?php
$load_fullcalendar = true;
?>
<style>
    .table th, .table td {
        vertical-align: middle !important;
    }
</style>
<div class="card card-outline card-primary rounded-0 shadow">
    <div class="card-header">
        <h3 class="card-title">List of Program Outcomes</h3>
        <?php if($_settings->userdata('type') == 'Administrator'): ?>
        <div class="card-tools">
            <a href="javascript:void(0)" id="create_new" class="btn btn-flat btn-sm btn-primary"><span class="fas fa-plus"></span> Add New Program Outcome</a>
        </div>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label for="program_filter" class="control-label">Filter by Program</label>
            <select id="program_filter" class="form-control form-control-sm">
                <option value="">All Programs</option>
                <?php 
                $programs = $conn->query("SELECT * FROM `program_list` ORDER BY `name` ASC");
                while($row = $programs->fetch_assoc()):
                ?>
                <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Program Outcome Code</th>
                    <th>Graduate Attribute</th>
                    <th>The graduates have the ability to:</th>
                    <th>IGO Infused to GO</th> <!-- Merged Column Header -->
                    <th>Performance Indicator</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="outcomes_list">
                <?php
                $i = 1;
                $query = "SELECT 
                            po.po_id, po.po_code, po.description, po.performance_indicator,
                            ga.attribute_name,
                            GROUP_CONCAT(DISTINCT i.igo_code ORDER BY i.igo_code SEPARATOR ', ') AS igo_codes,
                            GROUP_CONCAT(DISTINCT c.cpo_code ORDER BY c.cpo_code SEPARATOR ', ') AS cpo_codes,
                            po.program_id
                          FROM program_outcomes po
                          LEFT JOIN graduate_attributes ga ON po.graduate_attribute_id = ga.attribute_id
                          LEFT JOIN program_outcomes_igo poi ON po.po_id = poi.po_id
                          LEFT JOIN igo i ON poi.igo_id = i.igo_id
                          LEFT JOIN program_outcomes_cpo poc ON po.po_id = poc.po_id
                          LEFT JOIN cpo c ON poc.cpo_id = c.cpo_id
                          GROUP BY po.po_id";
                $result = $conn->query($query);

                while($row = $result->fetch_assoc()):
                    // Merging IGO and CPO Codes with Commas only
                    $merged_go = "";
                    if($row['igo_codes']) {
                        $merged_go .= $row['igo_codes'];  // Add IGO codes
                    }
                    if($row['cpo_codes']) {
                        if ($merged_go !== "") $merged_go .= ", ";  // Add comma separator between IGO and CPO
                        $merged_go .= $row['cpo_codes'];  // Add CPO codes
                    }
                ?>
                <tr data-program-id="<?= $row['program_id'] ?>">
                    <td><?= $i++; ?></td>
                    <td><?= htmlspecialchars($row['po_code']); ?></td>
                    <td><?= htmlspecialchars($row['attribute_name']); ?></td>
                    <td><?= htmlspecialchars($row['description']); ?></td>
                    <td><?= htmlspecialchars($merged_go ?: 'N/A'); ?></td> <!-- Merged GO Display -->
                    <td><?= htmlspecialchars($row['performance_indicator'] ?: 'N/A'); ?></td>
                    <td>
                        <a href="javascript:void(0)" class="btn btn-sm btn-primary edit_outcome" data-id="<?= $row['po_id']; ?>"><i class="fas fa-edit"></i></a>
                        <a href="javascript:void(0)" class="btn btn-sm btn-danger delete_outcome" data-id="<?= $row['po_id']; ?>"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#create_new').click(function(){
            uni_modal("Add New Program Outcome","program_outcomes/manage_outcome.php", "mid-large");
        });

        $('.edit_outcome').click(function(){
            var po_id = $(this).data('id');
            uni_modal("Edit Program Outcome", "program_outcomes/edit_program_outcome.php?po_id=" + po_id, "mid-large");
        });

        $('.delete_outcome').click(function(){
            var po_id = $(this).data('id');
            _conf("Are you sure you want to delete this program outcome?", "delete_outcome", [po_id]);
        });

        $('.table').dataTable({
            columnDefs: [
                { orderable: false, targets: 6 }  // Disable sorting for the last column (Action)
            ],
            lengthChange: false,  // Disable the length change option
            pageLength: 10000     // Set a large number for page length
        });

        $('#program_filter').change(function(){
            var selectedProgram = $(this).val();
            $('#outcomes_list tr').each(function(){
                var row = $(this);
                var programId = row.data('program-id');
                if(selectedProgram === "" || selectedProgram == programId){
                    row.show();
                } else {
                    row.hide();
                }
            });
        });
    });

    function delete_outcome(po_id){
        start_loader();
        $.ajax({
            url: _base_url_ + "admin/program_outcomes/delete_program_outcome.php",
            method: "POST",
            data: { po_id: po_id },
            dataType: 'json',
            success: function(resp){
                if(resp.status == 'success'){
                    alert_toast("Program outcome successfully deleted", 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    alert_toast(resp.message, 'error');
                }
            },
            error: function(err) {
                console.log(err);
                alert_toast("An error occurred", 'error');
            }
        });
    }
</script>
