<?php
	session_start();
	include_once('includes/crud.php');
$db = new Database();
$db->connect();
$db->sql("SET NAMES 'utf8'");
	// set time for session timeout
	$currentTime = time() + 25200;
	$expired = 3600;
	
	// if session not set go to login page
	if(!isset($_SESSION['user'])){
		header("location:index.php");
	}
	
	// if current time is more than session timeout back to login page
	if($currentTime > $_SESSION['timeout']){
		session_destroy();
		header("location:index.php");
	}
	
	// destroy previous session timeout and create new one
	unset($_SESSION['timeout']);
	$_SESSION['timeout'] = $currentTime + $expired;

	// print_r($_SESSION);
	$sql_query = "SELECT * FROM staff_details where staff_id=" . $_SESSION['id'];

	$db->sql($sql_query);
	$result = $db->getResult();
	foreach ($result as $row) {
		$user = $row['staff_fn'];
		$email = $row['staff_work_email'];
		// $profile = $row['profile'];
		$profile = "https://pbs.twimg.com/profile_images/864282616597405701/M-FEJMZ0_400x400.jpg";
		//$sb = $row['student_batch'];
		$sb = "2018,2019,2020";
	}
	$sb =  explode(",","2018,2019,2020");
	
?>
<?php include"header.php";?>
<html>
<head>
<title>Send Notification | <?=$settings['app_name']?> - Dashboard</title>
<style>
    .asterik {
    font-size: 20px;
    line-height: 0px;
    vertical-align: middle;
}
</style>
</head>
</body>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <?php include('public/add-college-notification-form.php'); ?>
      </div><!-- /.content-wrapper -->
  </body>
</html>

<?php include"footer.php";?>