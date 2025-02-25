<?php
require_once('../config.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
		}
	}
	function save_department(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!is_numeric($v))
					$v = $this->conn->real_escape_string($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `department_list` set {$data} ";
		}else{
			$sql = "UPDATE `department_list` set {$data} where id = '{$id}' ";
		}
		$check = $this->conn->query("SELECT * FROM `department_list` where `name` = '{$name}' ".(is_numeric($id) && $id > 0 ? " and id != '{$id}'" : "")." ")->num_rows;
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = 'Department Name already exists.';
			
		}else{
			$save = $this->conn->query($sql);
			if($save){
				$rid = !empty($id) ? $id : $this->conn->insert_id;
				$resp['id'] = $rid;
				$resp['status'] = 'success';
				if(empty($id))
					$resp['msg'] = "Department has successfully added.";
				else
					$resp['msg'] = "Department details has been updated successfully.";
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = "An error occured.";
				$resp['err'] = $this->conn->error."[{$sql}]";
			}
		}
		if($resp['status'] =='success')
			$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function delete_department(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `department_list` set delete_flag = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Department has been deleted successfully.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_program(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!is_numeric($v))
					$v = $this->conn->real_escape_string($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$data .= ", `delete_flag`=0"; // Ensure delete_flag is set to 0 for new entries
			$sql = "INSERT INTO `program_list` set {$data} ";
		}else{
			$sql = "UPDATE `program_list` set {$data} where id = '{$id}' ";
		}
		$check = $this->conn->query("SELECT * FROM `program_list` where `name` = '{$name}' and `department_id` = '{$department_id}' ".(is_numeric($id) && $id > 0 ? " and id != '{$id}'" : "")." ")->num_rows;
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = ' Course Name already exists on the selected Department.';
			
		}else{
			$save = $this->conn->query($sql);
			if($save){
				$rid = !empty($id) ? $id : $this->conn->insert_id;
				$resp['id'] = $rid;
				$resp['status'] = 'success';
				if(empty($id))
					$resp['msg'] = " Course has successfully added.";
				else
					$resp['msg'] = " Course details has been updated successfully.";
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = "An error occured.";
				$resp['err'] = $this->conn->error."[{$sql}]";
			}
		}
		if($resp['status'] =='success')
			$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function delete_program(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `program_list` SET delete_flag = 1 WHERE id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Course has been deleted successfully.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_student(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,['id'])){
				if(!is_numeric($v))
					$v = $this->conn->real_escape_string($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `student_list` set {$data} ";
		}else{
			$sql = "UPDATE `student_list` set {$data} where id = '{$id}' ";
		}
		
		$save = $this->conn->query($sql);
		if($save){
			$sid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['sid'] = $sid;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg']= " Student Information successfully saved.";
			else
				$resp['msg']= " Student Information successfully updated.";
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = "An error occured: Failed to save student.";
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] =='success')
			$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function delete_student(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `student_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Student has been deleted successfully.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_academic(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!is_numeric($v))
					$v = $this->conn->real_escape_string($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `academic_history` set {$data} ";
		}else{
			$sql = "UPDATE `academic_history` set {$data} where id = '{$id}' ";
		}
		$save = $this->conn->query($sql);
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = " Academic has successfully added.";
			else
				$resp['msg'] = " Academic details has been updated successfully.";
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = "An error occured.";
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] =='success')
			$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function delete_academic(){
		extract($_POST);
		$get = $this->conn->query("SELECT * FROM `academic_history` where id = '{$id}'");
		if($get->num_rows > 0){
			$res = $get->fetch_array();
		}
		$del = $this->conn->query("DELETE FROM `academic_history` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Academic has been deleted successfully.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function update_student_status(){
		extract($_POST);
		
		$update = $this->conn->query("UPDATE `student_list` set status = '{$status}' where id = '{$id}'");
		if($update){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Student's Status has been updated successfully.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	    // Save Faculty
		function save_faculty(){
			extract($_POST);
			$data = "";
			foreach($_POST as $k =>$v){
				if(!in_array($k,['id'])){
					if(!is_numeric($v))
						$v = $this->conn->real_escape_string($v);
					if(!empty($data)) $data .=",";
					$data .= " `{$k}`='{$v}' ";
				}
			}
			if(empty($id)){
				$sql = "INSERT INTO `faculty_list` set {$data} ";
			}else{
				$sql = "UPDATE `faculty_list` set {$data} where id = '{$id}' ";
			}
			$check = $this->conn->query("SELECT * FROM `faculty_list` ".(!empty($id) ? " and id != '{$id}' " : "")." ")->num_rows;
			if($check > 0){
				$resp['status'] = 'failed';
				$resp['msg'] = "Faculty ID already exists.";
			}else{
				$save = $this->conn->query($sql);
				if($save){
					$fid = !empty($id) ? $id : $this->conn->insert_id;
					$resp['fid'] = $fid;
					$resp['status'] = 'success';
					if(empty($id))
						$resp['msg']= " Faculty information successfully saved.";
					else
						$resp['msg']= " Faculty information successfully updated.";
				}else{
					$resp['status'] = 'failed';
					$resp['msg'] = "An error occured.";
					$resp['err'] = $this->conn->error."[{$sql}]";
				}
			}
			if($resp['status'] =='success')
				$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
		}
    // Delete Faculty
    function delete_faculty(){
        extract($_POST);
        $del = $this->conn->query("DELETE FROM `faculty_list` where id = '{$id}'");
        if($del){
            $resp['status'] = 'success';
            $this->settings->set_flashdata('success'," Faculty has been deleted successfully.");
        }else{
            $resp['status'] = 'failed';
            $resp['error'] = $this->conn->error;
        }
        return json_encode($resp);
    }
	public function save_course(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id'))){
				if(!is_array($v)){
					$data .= "`{$k}`='{$v}', ";
				} else {
					$data .= "`{$k}`='".json_encode($v)."', ";
				}
			}
		}
		$data = rtrim($data, ", ");
		if(empty($id)){
			$sql = "INSERT INTO `course_list` set {$data}";
		}else{
			$sql = "UPDATE `course_list` set {$data} where id = '{$id}'";
		}
		$save = $this->conn->query($sql);
		if($save){
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	// Udpate course function...
	function update_course(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id'))){
				if(!empty($data)) $data .= ", ";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(!empty($id)){
			$sql = "UPDATE `course_list` SET {$data} WHERE id = '{$id}'";
			$save = $this->conn->query($sql);
			if($save){
				$resp['status'] = 'success';
				$resp['msg'] = "Course details updated successfully.";
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = $this->conn->error;
			}
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = "Course ID is missing.";
		}
		return json_encode($resp);
	}
	// Add Student to Faculty
	public function add_student(){
		extract($_POST);
		$data = " faculty_id = '{$faculty_id}', student_id = '{$student_id}' ";
		$check = $this->conn->query("SELECT * FROM faculty_student_list WHERE faculty_id = '{$faculty_id}' AND student_id = '{$student_id}'")->num_rows;
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = 'Student already added.';
		}else{
			$save = $this->conn->query("INSERT INTO faculty_student_list set {$data}");
			if($save){
				$resp['status'] = 'success';
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = 'An error occured.';
			}
		}
		return json_encode($resp);
	}

	function delete_course(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `course_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Course has been deleted successfully.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	function get_course(){
		extract($_POST);
		$qry = $this->conn->query("SELECT * FROM `course_list` where id = '{$id}'");
		if($qry->num_rows > 0){
			$resp['status'] = 'success';
			$resp['data'] = $qry->fetch_assoc();
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = 'Course not found.';
		}
		return json_encode($resp);
	}

	public function save_subject() {
        extract($_POST);
        $data = " course_id = '$course_id', ";
        $data .= " status = '$status' ";

        if(empty($id)){
            $qry = $this->conn->query("INSERT INTO `subject_list` set {$data}");
            if($qry){
                return json_encode(['status' => 'success']);
            } else {
                return json_encode(['status' => 'failed', 'msg' => $this->conn->error]);
            }
        } else {
            $qry = $this->conn->query("UPDATE `subject_list` set {$data} where id = {$id}");
            if($qry){
                return json_encode(['status' => 'success', 'data' => $data, 'id' => $id]);
            } else {
                return json_encode(['status' => 'failed', 'msg' => $this->conn->error]);
            }
        }
    }

    public function delete_subject() {
        extract($_POST);
        $qry = $this->conn->query("UPDATE `subject_list` set `delete_flag` = 1 where id = $id");
        if($qry){
            return json_encode(['status' => 'success']);
        } else {
            return json_encode(['status' => 'failed', 'msg' => $this->conn->error]);
        }
    }

    public function add_student_to_subject() {
        extract($_POST);
        
        try {
            // First verify that the course exists
            $course_check = $this->conn->query("SELECT id FROM `course_list` WHERE id = '{$course_id}'");
            if($course_check->num_rows == 0) {
                throw new Exception('Invalid course selected.');
            }

            // Check if student is already enrolled using student_id instead of user id
            $check = $this->conn->query("SELECT * FROM `students_subject` 
                                        WHERE course_id = '{$course_id}' 
                                        AND student_id = '{$student_id}'");
            
            if($check->num_rows > 0) {
                throw new Exception('Student already added to this subject.');
            }

            // Begin transaction
            $this->conn->begin_transaction();

            // Insert new record with prepared statement
            $sql = "INSERT INTO `students_subject` 
                    (student_id, course_id, date_added, status) 
                    VALUES (?, ?, CURRENT_TIMESTAMP, 1)";
                    
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ii", $student_id, $course_id);
            
            if(!$stmt->execute()) {
                throw new Exception('Failed to add student to subject.');
            }

            $this->conn->commit();
            $resp['status'] = 'success';
            $resp['msg'] = 'Student successfully added to subject.';

        } catch (Exception $e) {
            if($this->conn->connect_errno) {
                $this->conn->rollback();
            }
            $resp['status'] = 'failed';
            $resp['msg'] = $e->getMessage();
        }
        
        return json_encode($resp);
    }

    public function delete_student_from_subject() {
        extract($_POST);
        $del = $this->conn->query("DELETE FROM `students_subject` WHERE student_id = '{$id}' AND course_id = '{$subject_id}'");
        if($del){
            $resp['status'] = 'success';
            $this->settings->set_flashdata('success',"Student has been removed from the subject successfully.");
        }else{
            $resp['status'] = 'failed';
            $resp['error'] = $this->conn->error;
        }
        return json_encode($resp);
    }

	public function save_program_outcome() {
    $data = json_decode(file_get_contents('php://input'), true);
    $course_id = $data['course_id'] ?? null;
    $program_outcomes = $data['program_outcomes'] ?? [];

    if(!$course_id) {
        return json_encode([
            'status' => 'failed',
            'msg' => 'Course ID is required'
        ]);
    }

    try {
        $this->conn->begin_transaction();

        // Prepare the update query to replace the existing outcomes
        $outcomes = empty($program_outcomes) ? NULL : implode(',', $program_outcomes);
        $sql = "UPDATE course_list SET program_outcomes = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $outcomes, $course_id);

        if (!$stmt->execute()) {
            throw new Exception("Failed to update program outcomes");
        }
        $stmt->close();

        // Verify the update
        $verify = $this->conn->query("SELECT program_outcomes FROM course_list WHERE id = '{$course_id}'");
        $result = $verify->fetch_assoc();

        $this->conn->commit();

        return json_encode([
            'status' => 'success',
            'msg' => 'Program outcomes updated successfully',
            'debug' => [
                'new_value' => $result['program_outcomes'],
                'sent_outcomes' => $program_outcomes ?? 'none'
            ]
        ]);

    } catch (Exception $e) {
        $this->conn->rollback();
        return json_encode([
            'status' => 'failed',
            'msg' => 'An error occurred: ' . $e->getMessage()
        ]);
    }
}
	public function update_faculty_status(){
        extract($_POST);
        $data = " status = '{$status}' ";
        $update = $this->conn->query("UPDATE `faculty_list` set {$data} where id = '{$id}'");
        if($update){
            $resp['status'] = 'success';
        }else{
            $resp['status'] = 'failed';
            $resp['msg'] = 'An error occurred while updating the status.';
        }
        return json_encode($resp);
    }

	public function delete_course_enrollment(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `course_enrollment` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Course Enrollment has been deleted successfully.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	public function save_learning_outcome() {
        extract($_POST);

        $learning_outcomes = json_decode($learning_outcomes, true);
        $errors = [];

        // Check if course_id exists in course_list table
        $course_check = $this->conn->query("SELECT id FROM course_list WHERE id = '{$course_id}'");
        if ($course_check->num_rows == 0) {
            $response = ['status' => 'error', 'msg' => 'Invalid course_id.'];
            echo json_encode($response);
            return;
        }

        foreach ($learning_outcomes as $outcome) {
            $id = isset($outcome['id']) ? $outcome['id'] : null;
            $learning_outcome_code = $outcome['learning_outcome_code'];
            $learning_outcome = $outcome['learning_outcome'];

            if ($id) {
                // Update existing learning outcome
                $stmt = $this->conn->prepare("UPDATE learning_outcomes SET learning_outcome_code = ?, learning_outcome = ? WHERE id = ?");
                $stmt->bind_param("ssi", $learning_outcome_code, $learning_outcome, $id);
            } else {
                // Insert new learning outcome
                $stmt = $this->conn->prepare("INSERT INTO learning_outcomes (course_id, learning_outcome_code, learning_outcome) VALUES (?, ?, ?)");
                $stmt->bind_param("iss", $course_id, $learning_outcome_code, $learning_outcome);
            }

            if (!$stmt->execute()) {
                $errors[] = $stmt->error;
            }

            $stmt->close();
        }

        if (empty($errors)) {
            $response = ['status' => 'success'];
        } else {
            $response = ['status' => 'error', 'msg' => implode(", ", $errors)];
        }

        echo json_encode($response);
    }

    public function delete_learning_outcome() {
        extract($_POST);

        $stmt = $this->conn->prepare("DELETE FROM learning_outcomes WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $response = ['status' => 'success'];
        } else {
            $response = ['status' => 'error', 'msg' => $stmt->error];
        }

        $stmt->close();
        echo json_encode($response);
    }

	function get_courses_by_program(){
		extract($_POST);
		$data = [];
		$qry = $this->conn->query("SELECT id, catalog_number, course_title FROM `course_list` WHERE `program_id` = '{$program_id}' ORDER BY `catalog_number` ASC");
		while($row = $qry->fetch_assoc()){
			$data[] = $row;
		}
		$resp['status'] = 'success';
		$resp['data'] = $data;
		return json_encode($resp);
	}

	public function get_program_outcomes_by_program() {
		extract($_POST);
		$qry = $this->conn->query("SELECT `po_code`, `description` FROM `program_outcomes` WHERE `program_id` = '{$program_id}'");
		$data = array();
		while($row = $qry->fetch_assoc()){
			$data[] = $row;
		}
		return json_encode(array('status'=>'success', 'data'=>$data));
	}

	public function add_course_to_faculty(){
        extract($_POST);
        $data = " faculty_id = '{$faculty_id}', course_id = '{$course_id}' ";
        $check = $this->conn->query("SELECT * FROM `faculty_courses` WHERE faculty_id = '{$faculty_id}' AND course_id = '{$course_id}'")->num_rows;
        if($check > 0) {
            $resp['status'] = 'failed';
            $resp['msg'] = "Course already assigned to this faculty.";
        } else {
            $save = $this->conn->query("INSERT INTO `faculty_courses` set {$data}");
            if($save) {
                $resp['status'] = 'success';
            } else {
                $resp['status'] = 'failed';
                $resp['msg'] = "An error occurred while saving the data.";
            }
        }
        return json_encode($resp);
    }

	public function delete_program_outcome() {
    extract($_POST);
    $course_id = $_POST['course_id'] ?? null;
    $po_code = $_POST['po_code'] ?? null;

    if (!$course_id || !$po_code) {
        return json_encode([
            'status' => 'failed',
            'msg' => 'Course ID and Program Outcome Code are required'
        ]);
    }

    try {
        $this->conn->begin_transaction();

        // Fetch current program outcomes
        $qry = $this->conn->query("SELECT program_outcomes FROM course_list WHERE id = '{$course_id}'");
        if ($qry->num_rows > 0) {
            $result = $qry->fetch_assoc();
            $program_outcomes = explode(',', $result['program_outcomes']);
            // Remove the specified program outcome
            $program_outcomes = array_filter($program_outcomes, function($code) use ($po_code) {
                return $code !== $po_code;
            });
            $new_outcomes = implode(',', $program_outcomes);

            // Update the program outcomes in the database
            $sql = "UPDATE course_list SET program_outcomes = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("si", $new_outcomes, $course_id);

            if (!$stmt->execute()) {
                throw new Exception("Failed to update program outcomes");
            }
            $stmt->close();

            $this->conn->commit();
            return json_encode([
                'status' => 'success',
                'msg' => 'Program outcome deleted successfully'
            ]);
        } else {
            throw new Exception("Course not found");
        }
    } catch (Exception $e) {
        $this->conn->rollback();
        return json_encode([
            'status' => 'failed',
            'msg' => 'An error occurred: ' . $e->getMessage()
        ]);
    }
}

public function get_student_details() {
    extract($_POST);
    
    $qry = $this->conn->query("SELECT 
        u.*, 
        ss.*,
        u.roll as roll,  /* Changed: Get roll directly from user table */
        ss.status as enrollment_status,
        ss.date_added as date_enrolled,
        CONCAT(u.firstname, ' ',
            CASE WHEN u.middlename IS NOT NULL AND u.middlename != ''
                THEN CONCAT(u.middlename, ' ')
                ELSE ''
            END,
            u.lastname) as fullname
        FROM students_subject ss
        INNER JOIN user u ON u.id = ss.student_id
        WHERE ss.student_id = '{$student_id}'
        AND ss.course_id = '{$course_id}'
        LIMIT 1");

    if($qry->num_rows > 0) {
        $data = $qry->fetch_assoc();
        $resp['status'] = 'success';
        $resp['data'] = array(
            'roll' => $data['roll'],  // Use the actual roll number from user table
            'fullname' => $data['fullname'],
            'firstname' => $data['firstname'],
            'middlename' => $data['middlename'],
            'lastname' => $data['lastname'],
            'gender' => $data['gender'] ?? 'N/A',
            'contact' => $data['contact'] ?? 'N/A',
            'address' => $data['address'] ?? 'N/A',
            'dob' => (!empty($data['dob']) && $data['dob'] != '0000-00-00') ? date("M d, Y", strtotime($data['dob'])) : 'N/A',
            'enrollment_status' => $data['enrollment_status'],
            'date_enrolled' => date("M d, Y", strtotime($data['date_enrolled']))
        );
    } else {
        $resp['status'] = 'failed';
        $resp['msg'] = 'Student not found.';
        $resp['sql'] = $this->conn->error;
    }
    return json_encode($resp);
}

public function update_student_subject() {
    extract($_POST);
    
    try {
        $this->conn->begin_transaction();

        // Debug log
        error_log("Updating student ID: $id, Course ID: $course_id");

        // Update user table
        $update_user = "UPDATE `user` SET 
            firstname = '" . addslashes($firstname) . "',
            middlename = '" . addslashes($middlename) . "',
            lastname = '" . addslashes($lastname) . "',
            status = '$status',
            roll = '" . addslashes($roll) . "',
            gender = '$gender',
            dob = '$dob',
            contact = '" . addslashes($contact) . "',
            address = '" . addslashes($address) . "'
            WHERE id = '$id'";

        $user_update = $this->conn->query($update_user);
        if (!$user_update) {
            throw new Exception("User update failed: " . $this->conn->error);
        }

        // Update students_subject table with grade
        $update_student_subject = "UPDATE `students_subject` SET 
            status = '$status',
            grade = " . ($grade !== '' ? "'$grade'" : "NULL") . "
            WHERE student_id = '$id' 
            AND course_id = '$course_id'";

        $subject_update = $this->conn->query($update_student_subject);
        if (!$subject_update) {
            throw new Exception("Student subject update failed: " . $this->conn->error);
        }

        $this->conn->commit();
        $resp['status'] = 'success';
        $resp['msg'] = 'Student information updated successfully';

    } catch (Exception $e) {
        $this->conn->rollback();
        $resp['status'] = 'failed';
        $resp['msg'] = 'Error updating student information: ' . $e->getMessage();
        error_log("Update failed: " . $e->getMessage());
    }
    
    return json_encode($resp);
}

    public function update_student_grade() {
    extract($_POST);
    
    try {
        $this->conn->begin_transaction();

        // Delete existing grades for this student and course
        $delete_sql = "DELETE FROM student_grades WHERE student_id = ? AND course_id = ?";
        $delete_stmt = $this->conn->prepare($delete_sql);
        $delete_stmt->bind_param("ii", $id, $course_id);
        $delete_stmt->execute();
        
        // Insert new grades
        $insert_sql = "INSERT INTO student_grades (student_id, course_id, po_code, grade) VALUES (?, ?, ?, ?)";
        $insert_stmt = $this->conn->prepare($insert_sql);
        
        foreach ($scores as $po_code => $grade) {
            $grade = floatval($grade);
            
            // Validate grade
            if ($grade < 1.0 || $grade > 9.0) {
                throw new Exception("Invalid grade value: $grade. Grades must be between 1.0 and 9.0");
            }
            
            $insert_stmt->bind_param("iiss", $id, $course_id, $po_code, $grade);
            if (!$insert_stmt->execute()) {
                throw new Exception("Failed to save grade for $po_code");
            }
        }

        $this->conn->commit();
        $resp['status'] = 'success';
        $resp['msg'] = 'Grades updated successfully';

    } catch (Exception $e) {
        $this->conn->rollback();
        $resp['status'] = 'failed';
        $resp['msg'] = 'Error updating grades: ' . $e->getMessage();
    }
    
    return json_encode($resp);
}

	public function get_student_grades() {
    extract($_POST);
    
    if(!isset($student_id) || !isset($course_id)) {
        $resp['status'] = 'failed';
        $resp['msg'] = 'Missing required parameters';
        return json_encode($resp);
    }

    try {
        // Get program outcome scores from the new table
        $po_scores = [];
        $scores_qry = $this->conn->query("SELECT po_code, grade 
                                        FROM student_grades 
                                        WHERE student_id = '{$student_id}' 
                                        AND course_id = '{$course_id}'");
        
        while($row = $scores_qry->fetch_assoc()) {
            $po_scores[$row['po_code']] = $row['grade'];
        }

        $resp['status'] = 'success';
        $resp['po_scores'] = $po_scores;

    } catch (Exception $e) {
        $resp['status'] = 'failed';
        $resp['msg'] = 'An error occurred: ' . $e->getMessage();
    }
    
    return json_encode($resp);
}
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save_department':
		echo $Master->save_department();
	break;
	case 'delete_department':
		echo $Master->delete_department();
	break;
	case 'save_program':
		echo $Master->save_program();
	break;
	case 'delete_program':
		echo $Master->delete_program();
	break;
	case 'save_student':
		echo $Master->save_student();
	break;
	case 'delete_student':
		echo $Master->delete_student();
	case 'save_faculty':
		echo $Master->save_faculty();
	break;
	case 'delete_faculty':
		echo $Master->delete_faculty();
	break;
	case 'save_academic':
		echo $Master->save_academic();
	break;
	case 'delete_academic':
		echo $Master->delete_academic();
	break;
	case 'update_student_status':
		echo $Master->update_student_status();
	break;
	case 'add_student':
		echo $Master->add_student();
	break;
	case 'save_course':
		echo $Master->save_course();
	break;
	case 'delete_course':
		echo $Master->delete_course();
		break;
	case 'get_course':
		echo $Master->get_course();
	break;
	case 'update_course':
		echo $Master->update_course();
		break;
	case 'save_subject':
        echo $Master->save_subject();
        break;
    case 'delete_subject':
        echo $Master->delete_subject();
        break;
    case 'add_student_to_subject':
        echo $Master->add_student_to_subject();
        break;
    case 'delete_student_from_subject':
        echo $Master->delete_student_from_subject();
        break;
	case 'save_program_outcome':
		echo $Master->save_program_outcome();
		break;
	case 'update_faculty_status':
		echo $Master->update_faculty_status();
		break;
	case 'delete_course_enrollment':
		echo $Master->delete_course_enrollment();
	break;
	case 'save_learning_outcome':
        echo $Master->save_learning_outcome();
        break;
	case 'delete_learning_outcome':
        echo $Master->delete_learning_outcome();
        break;
	case 'get_courses_by_program':
		echo $Master->get_courses_by_program();
		break;
	case 'get_program_outcomes_by_program':
		echo $Master->get_program_outcomes_by_program();
		break;
	case 'add_course_to_faculty':
		echo $Master->add_course_to_faculty();
		break;
	case 'delete_program_outcome':
		echo $Master->delete_program_outcome();
		break;
	case 'get_student_details':
		echo $Master->get_student_details();
		break;
	case 'update_student_subject':
		echo $Master->update_student_subject();
		break;
    case 'update_student_grade':
        echo $Master->update_student_grade();
        break;
	case 'get_student_grades':
		echo $Master->get_student_grades();
		break;
	default:
		// echo $sysset->index();
		break;
}

