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
$sql = "SELECT students.student_rollno,students.student_name,students.student_email,students.student_batch,department.department_hint,department.department_name
FROM students
LEFT JOIN department
ON students.student_department_id = department.id WHERE students.student_email = '" . $email . "'";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);

if ($num == 1) {
    $response['success'] = true;
    $response['message'] = "Login successfull";
    //$response['total'] = $total[0]['total'];
    $response['data'] = $res;
    print_r(json_encode($response));
    return false;

}
else {
    $response['success'] = false;
    $response['message'] = "Email invalid or Not Found";
    print_r(json_encode($response));
    return false;

}


?>