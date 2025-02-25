<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
    $link = "https"; 
else
    $link = "http"; 
$link .= "://"; 
$link .= $_SERVER['HTTP_HOST']; 
$link .= $_SERVER['REQUEST_URI'];

if(!isset($_SESSION['userdata']) && !strpos($link, 'login.php') && !strpos($link, 'register.php')){
	redirect('admin/login.php');
}
if(isset($_SESSION['userdata']) && strpos($link, 'login.php')){
	redirect('admin/index.php');
}

$module = array(
    'Administrator' => 'admin',
    'Faculty' => 'faculty',
    'Student' => 'student'
);

if(isset($_SESSION['userdata']) && isset($_SESSION['userdata']['login_type'])){
    $login_type = $_SESSION['userdata']['login_type'];
    $current_module = $module[$login_type];

    if(strpos($link, 'admin/') && $login_type != 'Administrator'){
        echo "<script>alert('Access Denied!');location.replace('".base_url.$current_module."');</script>";
        exit;
    }
    if(strpos($link, 'faculty/') && $login_type != 'Faculty' && $login_type != 'Administrator'){
        echo "<script>alert('Access Denied!');location.replace('".base_url.$current_module."');</script>";
        exit;
    }
    if(strpos($link, 'student/') && $login_type != 'Student'){
        echo "<script>alert('Access Denied!');location.replace('".base_url.$current_module."');</script>";
        exit;
    }
}
