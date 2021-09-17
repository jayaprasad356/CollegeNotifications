<?php
session_start();
include('./includes/variables.php');
include_once('includes/custom-functions.php');
$fn = new custom_functions;
ob_start(); 
    include_once('includes/crud.php');
    $db = new Database;
    
    $db->connect();
    $currentTime = time() + 25200;
	$expired = 3600;

	
    $email= $db->escapeString($fn->xss_clean($_POST['email']));
    $sql_query = "SELECT * FROM staff_details WHERE staff_work_email = '" . $email . "'";
		
		$db->sql($sql_query);
		/* store result */
		$res = $db->getResult();
    $num = $db->numRows($res);
    if ($num == 1) {
      
      echo "success";
      $_SESSION['id'] = $res[0]['staff_id'];
      
			$_SESSION['role'] = $res[0]['designation'];
			$_SESSION['user'] = $res[0]['staff_fn'];
			$_SESSION['timeout'] = $currentTime + $expired;
      
    }
    else {
      echo $email;

    }

 exit();
?>