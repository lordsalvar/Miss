<?php require_once('../config.php'); ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<?php require_once('inc/header.php') ?>
  <body class="layout-fixed control-sidebar-slide-open layout-navbar-fixed" data-new-gr-c-s-check-loaded="14.991.0" data-gr-ext-installed="" style="height: auto;">
    <div class="wrapper">
     <?php require_once('inc/topBarNav.php') ?>
     <?php require_once('inc/navigation.php') ?>
     <?php if($_settings->chk_flashdata('success')): ?>
      <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
      </script>
      <?php endif;?>    
     <?php $page = isset($_GET['page']) ? $_GET['page'] : 'submit_project';  ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper pt-3" style="min-height: 567.854px;">
     
        <!-- Main content -->
        <section class="content ">
          <div class="container-fluid">
            <h1 class="mt-4">Submit Final Project</h1>
            <hr class="border-purple">
            <div class="card mt-3">
              <div class="card-body">
                <form id="submit-project-form" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="project_file">Upload Project File</label>
                    <input type="file" class="form-control" id="project_file" name="project_file" required>
                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </form>
              </div>
            </div>
          </div>
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
      <?php require_once('inc/footer.php') ?>
  </body>
</html>

<script>
    $(document).ready(function(){
        $('#submit-project-form').submit(function(e){
            e.preventDefault();
            var formData = new FormData(this);
            start_loader();
            // Placeholder for AJAX request
            setTimeout(function(){
                alert_toast("Project submitted successfully.", 'success');
                end_loader();
            }, 1000);
        });

        // Ensure the "Subjects" tab remains highlighted
        $('a[href="view_subjects.php"]').parent().addClass('active');
        $('a[href="view_classes.php"]').parent().removeClass('active');
    });
</script>
