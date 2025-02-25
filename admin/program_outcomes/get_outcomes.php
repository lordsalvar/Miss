<?php
require_once('../../config.php');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_POST['program_id'])){
    $program_id = $_POST['program_id'];
    $outcomes = $conn->query("
        SELECT po.*, pl.name as program_name, cpo.name as cpo_name, igo.name as igo_name
        FROM program_outcomes po 
        JOIN program_list pl ON po.course_id = pl.id 
        JOIN common_program_outcomes cpo ON po.program_outcome_code = cpo.program_outcome_code
        JOIN institutional_graduate_outcome igo ON po.graduate_outcome_code = igo.graduate_outcome_code
        WHERE po.course_id = '$program_id' 
        ORDER BY po.graduate_attribute ASC
    ");
    if(!$outcomes) {
        echo "Error: " . $conn->error;
        exit;
    }
    $i = 1;
    while($row = $outcomes->fetch_assoc()):
?>
<tr>
    <td><?php echo $i++; ?></td>
    <td><?php echo $row['graduate_attribute']; ?></td>
    <td><?php echo $row['po_go_code']; ?></td>
    <td><?php echo $row['program_graduate_outcome']; ?></td>
    <td><?php echo $row['cpo_name']; ?></td>
    <td><?php echo $row['igo_name']; ?></td>
    <td><?php echo $row['performance_indicator']; ?></td>
    <td><?php echo $row['program_name']; ?></td>
    <td>
        <button class="btn btn-sm btn-primary edit_outcome" data-id="<?php echo $row['id']; ?>">Edit</button>
        <button class="btn btn-sm btn-danger delete_outcome" data-id="<?php echo $row['id']; ?>">Delete</button>
    </td>
</tr>
<?php
    endwhile;
}
?>
