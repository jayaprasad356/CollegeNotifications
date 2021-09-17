<?php


include('./includes/variables.php');
include_once('includes/custom-functions.php');
$fn = new custom_functions;


?>
<?php $sql_logo = "select value from `settings` where variable='Logo' OR variable='logo'";
$db->sql($sql_logo);
$res_logo = $db->getResult();

?>
<?php echo isset($error['update_user']) ? $error['update_user'] : ''; ?>
<div class="col-md-4 col-md-offset-4 " style="margin-top:150px;">
	<!-- general form elements -->
	<div class='row'>
		<div class="col-md-12 text-center">
			<img src="<?= DOMAIN_URL . 'dist/img/' . $res_logo[0]['value'] ?>" height="110">
			<!-- <h3><?= $settings['app_name'] ?> Dashboard</h3> -->
		</div>
		<div class="box box-info col-md-12">
			<div class="box-header with-border">
				<h3 class="box-title">Staff Login</h3>
				<center>
					<div class="msg"><?php echo isset($error['failed']) ? $error['failed'] : ''; ?></div>
				</center>
			</div><!-- /.box-header -->
			<!-- form start -->
			<div class="col-md-12 text-center">
			<a style="display:inline-block;" onclick="signin()"><img class="img-fluid" alt="Responsive image" src="./images/gsign.png"></a>
			</div>
		</div><!-- /.box -->
	</div>
</div>
<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script>
	var data = $('.msg').html();
	if (data != '') {
		$('.msg').show().delay(3000).fadeOut();
        // $('.msg').text("");
	}
</script> -->