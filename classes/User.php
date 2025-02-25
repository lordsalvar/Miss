<?php
require_once('../config.php');

class User {
    private $conn;
    private $settings;

    public function __construct($conn) {
        global $_settings;
        $this->conn = $conn;
        $this->settings = $_settings;
    }

    public function save() {
        extract($_POST);
        $data = "";
        foreach($_POST as $k => $v){
            if(!in_array($k, array('id', 'password', 'faculty_id', 'student_id'))){
                if(!empty($data)) $data .= ", ";
                $data .= " {$k}='{$v}' ";
            }
        }
        if(!empty($password)){
            $password = md5($password);
            $data .= ", password='{$password}' ";
        }
        if(empty($id)){
            $qry = $this->conn->query("INSERT INTO user set {$data}");
            if($qry){
                $id = $this->conn->insert_id;
                if($type == 2){
                    $this->conn->query("INSERT INTO faculty_list set user_id='{$id}', faculty_id='{$faculty_id}'");
                } elseif($type == 3){
                    $this->conn->query("INSERT INTO student_list set user_id='{$id}', student_id='{$student_id}'");
                }
                return 1;
            }
        } else {
            $qry = $this->conn->query("UPDATE user set {$data} where id = {$id}");
            if($qry){
                if($type == 2){
                    $this->conn->query("UPDATE faculty_list set faculty_id='{$faculty_id}' where user_id='{$id}'");
                } elseif($type == 3){
                    $this->conn->query("UPDATE student_list set student_id='{$student_id}' where user_id='{$id}'");
                }
                return 1;
            }
        }
        return 0;
    }

    public function update_user(){
        extract($_POST);
        $data = "";
        foreach($_POST as $k => $v){
            if(!in_array($k, array('id','password'))){
                if(!empty($data)) $data .= ", ";
                $data .= " {$k}='{$v}' ";
            }
        }
        if(!empty($password)){
            $password = md5($password);
            if(!empty($data)) $data .= ", ";
            $data .= " password='{$password}' ";
        }
        $check = $this->conn->query("SELECT * FROM user where username ='{$username}' and id != {$id}")->num_rows;
        if($check > 0){
            return 2;
            exit;
        }
        $sql = "UPDATE user set {$data} where id = {$id}";
        $update = $this->conn->query($sql);
        if($update){
            foreach($_POST as $k => $v){
                if(!in_array($k, array('id','password'))){
                    $this->settings->set_userdata($k, $v);
                }
            }
            return 1;
        }
        return 0;
    }
}

$User = new User($conn);
$action = isset($_GET['f']) ? $_GET['f'] : 'none';

if($action == 'save'){
    echo $User->save();
} elseif($action == 'update_user'){
    echo $User->update_user();
}
?>
