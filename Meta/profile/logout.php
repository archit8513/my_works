<?php 
include('../database/include.php');
session_unset();
session_destroy();
setcookie("uname","",time()-3600,'/');
// setcookie("mobile_num","",time()-3600,'/');
header("location: ../log_in/login.php");
$con->close();
exit();
?>