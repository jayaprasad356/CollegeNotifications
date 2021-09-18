<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include_once('../includes/crud.php');
$db = new Database();
$db->connect();
include_once('../includes/variables.php');
include_once('../includes/custom-functions.php');
$fn = new custom_functions;

$config = $fn->get_configurations();
$time_slot_config = $fn->time_slot_config();
if (isset($config['system_timezone']) && isset($config['system_timezone_gmt'])) {
    date_default_timezone_set($config['system_timezone']);
    $db->sql("SET `time_zone` = '" . $config['system_timezone_gmt'] . "'");
} else {
    date_default_timezone_set('Asia/Kolkata');
    $db->sql("SET `time_zone` = '+05:30'");
}
if (empty($_POST['email'])) {
    $response['success'] = false;
    $response['message'] = "Email should be filled!";
    print_r(json_encode($response));
    return false;
}
$email = $db->escapeString($fn->xss_clean($_POST['email']));

$sql = "SELECT student_pers_details.stu_pers_email,student_info.branch,student_info.AcdStYr
FROM student_pers_details
LEFT JOIN student_info
ON student_pers_details.stu_rollno = student_info.stu_rollno where student_pers_details.stu_pers_email = '" . $email . "'";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num == 1) {
    $batch = $res[0]['AcdStYr'];
    $branch = $res[0]['branch'];
    $catvalue = "hostel";

    $sql = "SELECT * FROM notifications where batch IN ($batch) AND department = '" . $branch . "'AND category = '" . $catvalue . "'";
    $db->sql($sql);
    $res = $db->getResult();
    $num = $db->numRows($res);
    if ($num >= 1) {
        $response['success'] = true;
        $response['message'] = "Hostel Notifications retrieved successfully";
        $response['data'] = $res;
        print_r(json_encode($response));
        return false;
    }
    else{
        $response['success'] = false;
        $response['message'] = "No Hostel Notifications";
        print_r(json_encode($response));
        return false;

    }

    

}
else {
    $response['success'] = false;
    $response['message'] = "Email invalid or Not Found";
    print_r(json_encode($response));
    return false;

}


?>