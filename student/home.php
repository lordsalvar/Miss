<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - <?php echo $_settings->info('name'); ?></title>
</head>
<body>
    <h1>My Classes (AY 2024-2025 2nd Semester)</h1>
    <hr class="border-purple">
    <style>
        #website-cover {
            width: 100%;
            height: 30em;
            object-fit: cover;
            object-position: center center;
        }
        .info-box {
            cursor: pointer;
        }
        .info-box.no-click {
            cursor: default;
        }
    </style>
    
    <div class="row">
        <!-- Empty tables similar to admin index page -->
        <div class="col-12">
            <div class="card card-outline card-primary rounded-0 shadow">
                <div class="card-header">
                    <h3 class="card-title">List of Courses</h3>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="filter_school_year" class="control-label">School Year</label>
                                <select id="filter_school_year" class="form-control form-control-sm">
                                    <option value="">All</option>
                                    <?php
                                    $school_years = $conn->query("SELECT DISTINCT school_year FROM course_enrollment ORDER BY school_year ASC");
                                    while($row = $school_years->fetch_assoc()):
                                    ?>
                                        <option value="<?= $row['school_year'] ?>"><?= $row['school_year'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="filter_semester" class="control-label">Semester</label>
                                <select id="filter_semester" class="form-control form-control-sm">
                                    <option value="">All</option>
                                    <option value="1">1st Semester</option>
                                    <option value="2">2nd Semester</option>
                                    <option value="3">Summer</option>
                                </select>
                            </div>
                        </div>
                        <table class="table table-bordered table-hover table-striped">
                            <colgroup>
                                <col width="5%">
                                <col width="15%">
                                <col width="20%">
                                <col width="10%">
                                <col width="10%">
                                <col width="10%">
                                <col width="10%">
                                <col width="10%">
                                <col width="10%">
                            </colgroup>
                            <thead>
                                <tr class="bg-gradient-dark text-light">
                                    <th>#</th>
                                    <th>Catalog Number</th>
                                    <th>Course Title</th>
                                    <th>Credit Unit</th>
                                    <th>Hours</th>
                                    <th>Instructor</th>
                                    <th>Room</th>
                                    <th>Schedule</th>
                                    <th>Section</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Empty table rows -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<script>
    $(document).ready(function(){
        $('.table td, .table th').addClass('py-1 px-2 align-middle')
        $('.table').dataTable({
            columnDefs: [
                { orderable: false, targets: 8 }
            ],
        });

        $('#filter_school_year, #filter_semester').change(function(){
            var school_year = $('#filter_school_year').val();
            var semester = $('#filter_semester').val();
            $('#academic-history tbody tr').each(function(){
                var row_school_year = $(this).data('school-year');
                var row_semester = $(this).data('semester');
                if((school_year == '' || school_year == row_school_year) && (semester == '' || semester == row_semester)){
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
</script>