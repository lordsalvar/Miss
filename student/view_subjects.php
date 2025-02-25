<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - <?php echo $_settings->info('name'); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <h1>My Subjects (AY 2024-2025 2nd Semester)</h1>
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
        .subject-card {
            cursor: pointer;
            transition: transform 0.3s;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }
        .subject-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .subject-icon {
            font-size: 2rem;
            color: #6c757d; /* Gray color */
            background: #f0f0f0;
            border-radius: 8px;
            padding: 10px;
            display: inline-block;
            margin-right: 10px;
        }
        .subject-card .card-body {
            padding: 20px;
            display: flex;
            align-items: center;
        }
        .subject-card .card-title {
            margin-top: 0;
            font-size: 1.2rem;
        }
        .subject-card .card-text {
            font-size: 0.9rem;
            color: #666;
        }
    </style>
    
    <div class="row">
        <!-- List of clickable subjects for submitting final projects -->
        <div class="col-12">
            <div class="card card-outline card-primary rounded-0 shadow">
                <div class="card-header">
                    <h3 class="card-title">List of Subjects</h3>
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
                        <div class="row">
                            <!-- Example subjects -->
                            <div class="col-md-4 mb-3">
                                <div class="card subject-card" data-id="1">
                                    <div class="card-body">
                                        <i class="fas fa-user-graduate subject-icon"></i>
                                        <div>
                                            <h5 class="card-title">Introduction to Computer Science</h5>
                                            <p class="card-text">CS101</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card subject-card" data-id="2">
                                    <div class="card-body">
                                        <i class="fas fa-user-graduate subject-icon"></i>
                                        <div>
                                            <h5 class="card-title">Data Structures and Algorithms</h5>
                                            <p class="card-text">CS201</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card subject-card" data-id="3">
                                    <div class="card-body">
                                        <i class="fas fa-user-graduate subject-icon"></i>
                                        <div>
                                            <h5 class="card-title">Database Management Systems</h5>
                                            <p class="card-text">CS301</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Dynamic subjects from database -->
                            <?php 
                            $subjects = $conn->query("SELECT s.*, c.course_title, c.catalog_number FROM `subject_list` s LEFT JOIN `course_list` c ON s.course_id = c.id WHERE s.delete_flag = 0 ORDER BY c.course_title ASC");
                            while($row = $subjects->fetch_assoc()):
                            ?>
                            <div class="col-md-4 mb-3">
                                <a href="submit_project.php?subject_id=<?= $row['id'] ?>" class="card subject-card" data-id="<?= $row['id'] ?>">
                                    <div class="card-body">
                                        <i class="fas fa-user-graduate subject-icon"></i>
                                        <div>
                                            <h5 class="card-title"><?= $row['course_title'] ?></h5>
                                            <p class="card-text"><?= $row['catalog_number'] ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<script>
    $(document).ready(function(){
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

        $('.subject-card').click(function(){
            var subject_id = $(this).data('id');
            window.location.href = "submit_project.php?subject_id=" + subject_id;
        });

        // Ensure only the "Subjects" tab remains highlighted
        $('a[href="view_subjects.php"]').parent().addClass('active');
    });
</script>