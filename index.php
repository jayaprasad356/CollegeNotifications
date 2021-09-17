<?php session_start();
    ob_start(); 
    include_once('includes/crud.php');
    $db = new Database;
    include_once('includes/custom-functions.php');
    $fn = new custom_functions();
    $db->connect();
    date_default_timezone_set('Asia/Kolkata');
    $sql = "SELECT * FROM settings";
    $db->sql($sql);
    $res = $db->getResult();
    $settings = json_decode($res[5]['value'],1);
    $logo = $fn->get_settings('logo');
    
    ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="icon" type="image/ico" href="<?= DOMAIN_URL . 'dist/img/'.$logo?>">
	<title>Admin Login - <?=$settings['app_name']?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/4.8.1/firebase.js"></script>
    <script>
        function signin() {
            var provider = new firebase.auth.GoogleAuthProvider();
            firebase.auth().signInWithPopup(provider).then(function(result) {
            // This gives you a Google Access Token. You can use it to access the Google API.
            var token = result.credential.accessToken;
            // The signed-in user info.
            var user = result.user;
            
            var email= user.email;
            $.ajax
          ({
          type:'post',
          url:'checklogin.php',
          data:{
          checklogin:"checklogin",
          email:email
          },
          success:function(response) {
            
          if(response=="success")
          {
            window.location.href = './home.php';
          }
          else
          {
            
            alert("Not Registered");
          }
          }
          });
            // ...
            }).catch(function(error) {
            // Handle Errors here.
            var errorCode = error.code;
            var errorMessage = error.message;
            // The email of the user's account used.
            var email = error.email;
            // The firebase.auth.AuthCredential type that was used.
            var credential = error.credential;
            // ...
            });
          
        }
        
      </script>
      <script type="text/javascript">
      // Initialize Firebase
      var config = {
        apiKey: "AIzaSyAKpRDunoIVj8A7p6DgJNuJj8VHPr_hBNE",
        authDomain: "web-app-3fda2.firebaseapp.com",
        databaseURL: "https://web-app-3fda2.firebaseio.com",
        projectId: "web-app-3fda2",
        storageBucket: "web-app-3fda2.appspot.com",
        messagingSenderId: "414010710177",
        appId: "1:414010710177:web:6498079a749baa1604f8e0",
        measurementId: "G-SE41CE5P4B"
        
      };
      firebase.initializeApp(config);
    </script>
  </head>
</body>
      <!-- Content Wrapper. Contains page content -->
       <?php include 'public/google-sign-in-form.php'; ?>
  </body>
</html>