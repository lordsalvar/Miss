<?php
require_once '../config.php';
class Login extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;

		parent::__construct();
		ini_set('display_errors', 1);
	}
	public function __destruct(){
		parent::__destruct();
	}
	public function index(){
		echo "<h1>Access Denied</h1> <a href='".base_url."'>Go Back.</a>";
	}
	public function login(){
		extract($_POST);
		$stmt = $this->conn->prepare("SELECT * FROM user WHERE username = ? AND password = ?");
		$pw = md5($password);
		$stmt->bind_param('ss', $username, $pw);
		$stmt->execute();
		$qry = $stmt->get_result();
		if($qry->num_rows > 0){
			$res = $qry->fetch_assoc();
			foreach($res as $k => $v){
				if(!is_numeric($k) && $k != 'password'){
					$this->settings->set_userdata($k, $v);
				}
			}
			$this->settings->set_userdata('login_type', $res['type']); // Set the correct user type
			$redirect_url = 'admin/index.php'; // Default redirect URL

			switch ($res['type']) {
				case 'Administrator':
					$redirect_url = 'admin/index.php';
					break;
				case 'Faculty':
					$redirect_url = 'faculty/index.php';
					break;
				case 'Student':
					$redirect_url = 'student/index.php';
					break;
				default:
					$redirect_url = 'index.php';
					break;
			}

			return json_encode(array('status'=>'success', 'type' => $res['type'], 'redirect_url' => $redirect_url)); // Return the user type and redirect URL
		}else{
			return json_encode(array('status'=>'incorrect','error'=>'Invalid username or password.'));
		}
	}
	public function logout(){
		if($this->settings->sess_des()){
			redirect('/sis/login.php');
		}
	}
}
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$auth = new Login();
switch ($action) {
	case 'login':
		echo $auth->login();
		break;
	case 'logout':
		echo $auth->logout();
		break;
	default:
		echo $auth->index();
		break;
}

