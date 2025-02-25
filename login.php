<?php require_once('config.php') ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<?php require_once('inc/header.php') ?>
<body class="hold-transition">
  <script>
    start_loader()
  </script>
  <style>
    html, body{
      height: 100% !important;
      width: 100% !important;
      background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);
    }
    .login-title {
      color: #fff;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
      font-size: 2.5rem;
      margin-bottom: 2rem;
      font-weight: 700;
    }
    #login {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 2rem;
    }
    #logo-img {
      height: 120px;
      width: 120px;
      object-fit: cover;
      border-radius: 50%;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
      margin-bottom: 1.5rem;
      border: 3px solid #fff;
      margin: 0 10px;
    }
    .logo-container {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-bottom: 1.5rem;
    }
    .login-box {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 15px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
      padding: 2rem;
      width: 100%;
      max-width: 400px;
      transition: transform 0.3s ease;
    }
    .login-box:hover {
      transform: translateY(-5px);
    }
    .login-header {
      text-align: center;
      margin-bottom: 2rem;
    }
    .login-header h4 {
      color: #333;
      font-size: 1.5rem;
      font-weight: 600;
      margin: 1rem 0;
    }
    .form-control {
      border-radius: 25px;
      padding: 0.75rem 1.25rem;
      border: 1px solid #ddd;
      transition: all 0.3s ease;
    }
    .form-control:focus {
      border-color: #4b6cb7;
      box-shadow: 0 0 0 0.2rem rgba(75, 108, 183, 0.25);
    }
    .input-group-text {
      border-radius: 25px;
      background: #f8f9fa;
      border: 1px solid #ddd;
      padding: 0.75rem 1.25rem;
    }
    .btn-primary {
      border-radius: 25px;
      padding: 0.75rem 2rem;
      background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);
      border: none;
      width: 100%;
      font-weight: 600;
      letter-spacing: 0.5px;
      transition: all 0.3s ease;
    }
    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
      background: linear-gradient(135deg, #182848 0%, #4b6cb7 100%);
    }
    .input-group {
      margin-bottom: 1.5rem;
    }
    .input-group-append {
      margin-left: -45px;
      z-index: 10;
    }
    .input-group-text {
      background: transparent;
      border: none;
      color: #666;
    }
    .remember-me {
      display: flex;
      align-items: center;
      margin-bottom: 1rem;
    }
    .remember-me input {
      margin-right: 0.5rem;
    }
  </style>

  <div id="login">
    <div class="login-box">
      <div class="login-header">
        <div class="logo-container">
          <img src="<?= validate_image('uploads/CCIS.png') ?>" alt="CCIS Logo" id="logo-img">
          <img src="<?= validate_image('uploads/CJCLOGO.png') ?>" alt="CJC Logo" id="logo-img">
        </div>
        <h4><?php echo $_settings->info('name') ?></h4>
      </div>
      <form id="login-frm" action="" method="post">
        <div class="input-group">
          <input type="text" class="form-control" name="username" placeholder="Username" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <i class="fas fa-user"></i>
            </div>
          </div>
        </div>
        <div class="input-group">
          <input type="password" class="form-control" name="password" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <i class="fas fa-lock"></i>
            </div>
          </div>
        </div>
        <div class="remember-me">
          <input type="checkbox" id="remember" name="remember">
          <label for="remember">Remember me</label>
        </div>
        <button type="submit" class="btn btn-primary">Sign In</button>
      </form>
    </div>
  </div>

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>

  <script>
    $(document).ready(function(){
      end_loader();
    })

    $('#login-frm').submit(function(e){
      e.preventDefault();
      start_loader();
      $.ajax({
        url: _base_url_+'classes/Login.php?f=login',
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        error: err => {
          console.log(err);
          alert_toast("An error occurred.", 'error');
          end_loader();
        },
        success: function(resp){
          if(resp.status == 'success'){
            var userType = resp.type;
            if(userType == 'Administrator') { 
              location.href = '<?php echo base_url ?>admin';
            } else if(userType == 'Faculty') {
              location.href = '<?php echo base_url ?>faculty';
            } else if(userType == 'Student') {
              location.href = '<?php echo base_url ?>student';
            } else {
              location.href = '<?php echo base_url ?>';
            }
          } else {
            alert_toast("Invalid username or password.", 'error');
            end_loader(); // Ensure the loader is stopped if login fails
          }
        }
      })
    })
  </script>
</body>
</html>