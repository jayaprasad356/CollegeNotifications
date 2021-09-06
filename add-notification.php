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
	$sql_query = "SELECT * FROM admin where id=" . $_SESSION['id'];

	$db->sql($sql_query);
	$result = $db->getResult();
	foreach ($result as $row) {
		$user = $row['username'];
		$email = $row['email'];
		$profile = $row['profile'];
		$sb = $row['student_batch'];
	}
	$sb =  explode(",",$row['student_batch']);
	
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
        <?php include('public/add-product-form.php'); ?>
      </div><!-- /.content-wrapper -->
  </body>
</html>

<?php include"footer.php";?>