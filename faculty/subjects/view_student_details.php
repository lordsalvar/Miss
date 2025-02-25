<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h4 class="text-primary">Student Information</h4>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <dl>
                        <dt>Student ID:</dt>
                        <dd id="roll" class="pl-3"></dd>
                        
                        <dt>First Name:</dt>
                        <dd id="firstname" class="pl-3"></dd>

                        <dt>Middle Name:</dt>
                        <dd id="middlename" class="pl-3"></dd>

                        <dt>Last Name:</dt>
                        <dd id="lastname" class="pl-3"></dd>

                        <dt>Gender:</dt>
                        <dd id="gender" class="pl-3"></dd>

                        <dt>Date of Birth:</dt>
                        <dd id="dob" class="pl-3"></dd>
                    </dl>
                </div>
                <div class="col-md-6">
                    <dl>
                        <dt>Contact:</dt>
                        <dd id="contact" class="pl-3"></dd>

                        <dt>Address:</dt>
                        <dd id="address" class="pl-3"></dd>

                        <dt>Enrollment Status:</dt>
                        <dd id="enrollment_status" class="pl-3"></dd>

                        <dt>Date Enrolled:</dt>
                        <dd id="date_enrolled" class="pl-3"></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        var student_id = '<?= isset($_GET['id']) ? $_GET['id'] : '' ?>';
        var course_id = '<?= isset($_GET['course_id']) ? $_GET['course_id'] : '' ?>';
        
        $.ajax({
            url: _base_url_+'classes/Master.php?f=get_student_details',
            method: 'POST',
            data: {student_id: student_id, course_id: course_id},
            dataType: 'json',
            success:function(resp){
                if(resp.status == 'success'){
                    console.log('Full Response:', resp); // Added debug log
                    console.log('Student Data:', resp.data); // Added debug log
                    $('#roll').text(resp.data.roll || 'N/A');  // Added fallback
                    $('#firstname').text(resp.data.firstname);
                    $('#middlename').text(resp.data.middlename || 'N/A');
                    $('#lastname').text(resp.data.lastname);
                    $('#gender').text(resp.data.gender || 'N/A');
                    $('#contact').text(resp.data.contact || 'N/A');
                    $('#address').text(resp.data.address || 'N/A');
                    $('#dob').text(resp.data.dob || 'N/A');
                    $('#enrollment_status').html(
                        resp.data.enrollment_status == 1 ? 
                        '<span class="badge badge-success">Active</span>' : 
                        '<span class="badge badge-danger">Inactive</span>'
                    );
                    $('#date_enrolled').text(resp.data.date_enrolled);
                }else{
                    console.log('Error Response:', resp); // Added debug log
                    alert_toast(resp.msg, 'error');
                }
            },
            error: function(xhr, status, error) {
                console.log('XHR:', xhr);
                console.log('Status:', status);
                console.log('Error:', error);
                alert_toast("An error occurred", 'error');
            }
        });
    });
</script>
