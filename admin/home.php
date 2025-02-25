<h1>Welcome to <?php echo $_settings->info('name') ?> - Admin Dashboard</h1>
<hr class="border-purple">
<style>
    #website-cover{
        width:100%;
        height:30em;
        object-fit:cover;
        object-position:center center;
    }
    .info-box {
        cursor: pointer;
    }
    .info-box.no-click {
        cursor: default;
    }
    .welcome-section {
        background: linear-gradient(135deg, #1a237e 0%, #121858 100%);
        padding: 2rem;
        border-radius: 15px;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        position: relative;
        overflow: hidden;
    }
    .welcome-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('<?= validate_image($_settings->info('logo'))?>')no-repeat center right;
        background-size: contain;
        opacity: 0.1;
    }
    .welcome-heading {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    }
    .date-time {
        font-size: 1.1rem;
        opacity: 0.9;
        font-weight: 300;
    }
    .info-box {
        transition: all 0.3s ease;
        border-radius: 15px;
        overflow: hidden;
        margin-bottom: 1.5rem;
        background: white;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .info-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
    }
    .info-box-icon {
        border-radius: 10px;
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin: 1rem;
    }
    .info-box-content {
        padding: 1.5rem;
    }
    .info-box-number {
        font-size: 2rem;
        font-weight: 700;
        display: block;
        margin-top: 0.5rem;
        color: #1a237e;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .trend-indicator {
        font-size: 0.9rem;
        padding: 0.2rem 0.5rem;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .trend-up {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }
    .trend-down {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }
    #website-cover {
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-top: 2rem;
        height: 400px;
    }
    .stats-container {
        animation: fadeInUp 0.5s ease;
        margin-bottom: 2rem;
    }
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .dashboard-container {
        padding: 1.5rem;
        margin-top: 1rem;
    }
    .cover-container {
        background: white;
        padding: 1rem;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
</style>

<div class="dashboard-container">
    <div class="welcome-section">
        <div class="welcome-heading">
            <span id="greeting"></span>, Administrator!
        </div>
        <div class="date-time" id="datetime"></div>
    </div>

    <div class="row stats-container">
        <div class="col-12 col-sm-12 col-md-6 col-lg-3">
            <div class="info-box bg-white shadow" onclick="location.href='./?page=departments'">
                <span class="info-box-icon bg-gradient-primary elevation-1"><i class="fas fa-building"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Departments</span>
                    <span class="info-box-number">
                        <?php echo $conn->query("SELECT * FROM `department_list` where delete_flag= 0 and `status` = 1 ")->num_rows; ?>
                        <span class="trend-indicator trend-up"><i class="fas fa-arrow-up"></i> 5%</span>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-3">
            <div class="info-box bg-white shadow" onclick="location.href='./?page=courses'">
                <span class="info-box-icon bg-gradient-primary elevation-1"><i class="fas fa-scroll"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Programs</span>
                    <span class="info-box-number text-right">
                        <?php 
                            echo $conn->query("SELECT * FROM `program_list` where delete_flag= 0 and `status` = 1 ")->num_rows;
                        ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-3">
            <div class="info-box bg-white shadow" onclick="location.href='./?page=students'">
                <span class="info-box-icon bg-gradient-warning elevation-1"><i class="fas fa-user-friends"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Students</span>
                    <span class="info-box-number text-right">
                        <?php 
                            echo $conn->query("SELECT * FROM `user` WHERE `type` = 'Student'")->num_rows;
                        ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-3">
            <div class="info-box bg-white shadow" onclick="location.href='./?page=faculty/findex'">
                <span class="info-box-icon bg-gradient-info elevation-1"><i class="fas fa-user-tie"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Faculty Staff</span>
                    <span class="info-box-number text-right">
                        <?php 
                            echo $conn->query("SELECT * FROM `user` WHERE `type` = 'faculty'")->num_rows;
                        ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="cover-container">
        <div class="row">
            <div class="col-md-12">
                <img src="<?= validate_image($_settings->info('cover')) ?>" alt="Website Cover" class="img-fluid border w-100" id="website-cover">
            </div>
        </div>
    </div>
</div>

<script>
    // Update greeting based on time of day
    function setGreeting() {
        const hour = new Date().getHours();
        const greeting = document.getElementById('greeting');
        if (hour < 12) greeting.innerHTML = "Good Morning";
        else if (hour < 18) greeting.innerHTML = "Good Afternoon";
        else greeting.innerHTML = "Good Evening";
    }

    // Update date and time
    function updateDateTime() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
        document.getElementById('datetime').innerHTML = now.toLocaleDateString('en-US', options);
    }

    // Initialize
    setGreeting();
    updateDateTime();
    setInterval(updateDateTime, 60000); // Update every minute

    // Add hover animation for info boxes
    document.querySelectorAll('.info-box').forEach(box => {
        box.addEventListener('mouseover', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 10px 20px rgba(0,0,0,0.1)';
            const icon = this.querySelector('.info-box-icon');
            icon.style.transform = 'scale(1.1)';
        });
        box.addEventListener('mouseout', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
            const icon = this.querySelector('.info-box-icon');
            icon.style.transform = 'scale(1)';
        });
    });
</script>
