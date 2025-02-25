<?php
// Include necessary files and initialize database connection
// include '../config.php'; // Assuming you have a config file for database connection
// $_settings = new SystemSettings(); // Assuming you have a Settings class for site info
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Dashboard - <?php echo $_settings->info('name'); ?></title>
</head>
<body>
    <h1>Welcome to <?php echo $_settings->info('name'); ?> - Faculty Dashboard</h1>
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
        <!-- Total Courses -->
        <div class="col-12 col-sm-12 col-md-6 col-lg-3">
            <div class="info-box bg-gradient-light shadow" onclick="location.href='./?page=subjects'">
                <span class="info-box-icon bg-gradient-primary elevation-1"><i class="fas fa-book"></i></span> <!-- Changed icon -->
                <div class="info-box-content">
                    <span class="info-box-text">Total Subjects</span>
                    <span class="info-box-number text-right">
                        <?php 
                            echo $conn->query("SELECT * FROM `course_list`")->num_rows;
                        ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Total Faculty -->
        <div class="col-12 col-sm-12 col-md-6 col-lg-3">
            <div class="info-box bg-gradient-light shadow no-click">
                <span class="info-box-icon bg-gradient-warning elevation-1"><i class="fas fa-user-graduate"></i></span> <!-- Changed icon -->
                <div class="info-box-content">
                    <span class="info-box-text">Total Students</span>
                    <span class="info-box-number text-right">
                        <?php 
                            echo $conn->query("SELECT * FROM `faculty_list`")->num_rows;
                        ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Total Assignments -->
        <!-- <div class="col-12 col-sm-12 col-md-6 col-lg-3">
            <div class="info-box bg-gradient-light shadow" onclick="location.href='./?page=assignments'">
                <span class="info-box-icon bg-gradient-success elevation-1"><i class="fas fa-tasks"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Assignments</span>
                    <span class="info-box-number text-right">
                        <?php 
                            echo $conn->query("SELECT * FROM `assignment_list` WHERE delete_flag = 0")->num_rows;
                        ?>
                    </span>
                </div>
            </div>
        </div> -->

        <!-- Total Feedback -->
        <!-- <div class="col-12 col-sm-12 col-md-6 col-lg-3">
            <div class="info-box bg-gradient-light shadow" onclick="location.href='./?page=feedback'">
                <span class="info-box-icon bg-gradient-danger elevation-1"><i class="fas fa-comments"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Feedback</span>
                    <span class="info-box-number text-right">
                        <?php 
                            echo $conn->query("SELECT * FROM `feedback_list` WHERE delete_flag = 0")->num_rows;
                        ?>
                    </span>
                </div>
            </div>
        </div> -->
    </div>
</body>
</html>