<style>
    .img-thumb-path{
        width:80px;
        height:60px;
        object-fit:scale-down;
        object-position:center center;
    }
    .subject-card {
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 8px 16px rgba(0,0,0,0.06);
        margin: 1rem;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 200px;
        position: relative;
        border: none;
        display: flex;
        flex-direction: column;
    }
    .subject-card:hover {
        transform: translateY(-15px);
        box-shadow: 0 15px 30px rgba(66,133,244,0.3);
    }
    .subject-card .card-header {
        background: linear-gradient(135deg, #1a73e8, #34a853);
        color: white;
        padding: 1.5rem;
        border-radius: 20px 20px 0 0;
        margin: 0;
        height: 80px;
        display: flex;
        align-items: left;
        justify-content: left;
        position: relative;
        overflow: hidden;
    }
    .subject-card .card-header:before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 100%);
        z-index: 1;
    }
    .subject-card .card-body {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        align-items: left;
        justify-content: left;
        background-color: #ffffff;
        position: relative;
    }
    .subject-card .card-title {
        margin: 0;
        font-size: 2rem;
        font-weight: 800;
        text-align: left;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        letter-spacing: 2px;
        position: relative;
        z-index: 2;
    }
    .subject-card .card-text {
        color: #2d3436;
        font-size: 1.1rem;
        text-align: left;
        margin: 0;
        font-weight: 500;
        line-height: 1.6;
        padding: 0 1rem;
    }
    .subject-card .card-actions {
        margin-top: 1rem;
        text-align: right;
    }
    .subject-card .card-actions a {
        margin-left: 0.5rem;
    }
    .row {
        margin: -1.5rem;
        padding: 1rem;
    }
    .col-md-4 {
        padding: 0.5rem;
    }
    @media (max-width: 768px) {
        .subject-card {
            height: 180px;
            margin: 1rem;
        }
        .subject-card .card-header {
            height: 70px;
            padding: 1rem;
        }
        .subject-card .card-title {
            font-size: 1.75rem;
        }
        .subject-card .card-text {
            font-size: 1rem;
        }
    }
</style>
<body>
    <div class="container-fluid">
        <div class="card card-outline card-primary rounded-0 shadow">
            <div class="card-header">
                <h3 class="card-title">List of Subjects</h3>
                <div class="card-tools">
                    <a href="./?page=subjects/manage_subject" class="btn btn-flat btn-sm btn-primary"><span class="fas fa-plus"></span> Add New Subject</a>
                </div>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <?php 
                        $faculty_id = $_SESSION['userdata']['id'];
                        $subjects = $conn->query("SELECT fc.*, c.catalog_number, c.course_title 
                                                  FROM `faculty_courses` fc 
                                                  LEFT JOIN `course_list` c ON fc.course_id = c.id 
                                                  WHERE fc.faculty_id = '$faculty_id'");
                        if($subjects->num_rows > 0):
                            while($row = $subjects->fetch_assoc()):
                        ?>
                        <div class="col-md-4">
                            <div class="subject-card" onclick="location.href='./?page=subjects/view_subject&id=<?= $row['course_id'] ?>'" style="cursor: pointer;">
                                <div class="card-header">
                                    <h2 class="card-title"><?= $row['catalog_number'] ?></h2>
                                </div>
                                <div class="card-body">
                                    <p class="card-text"><?= $row['course_title'] ?></p>
                                </div>
                            </div>
                        </div>
                        <?php 
                            endwhile;
                        else:
                        ?>
                        <div class="col-12">
                            <div class="alert alert-info text-center">No subjects found for the logged-in faculty user.</div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('#create_new').click(function(){
                window.location.href = "./?page=subjects/manage_subject";
            })
        })
    </script>
</body>
</html>
