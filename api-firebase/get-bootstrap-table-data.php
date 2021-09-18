<?php
session_start();

// set time for session timeout
$currentTime = time() + 25200;
$expired = 3600;

// // if session not set go to login page
// if (!isset($_SESSION['user'])) {
//     header("location:index.php");
// }

// // if current time is more than session timeout back to login page
// if ($currentTime > $_SESSION['timeout']) {
//     session_destroy();
//     header("location:index.php");
// }

// destroy previous session timeout and create new one
unset($_SESSION['timeout']);
$_SESSION['timeout'] = $currentTime + $expired;

header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


include_once('../includes/custom-functions.php');
$fn = new custom_functions;
include_once('../includes/crud.php');
include_once('../includes/variables.php');
$db = new Database();
$db->connect();
$config = $fn->get_configurations();
$low_stock_limit = $config['low-stock-limit'];




if (isset($_GET['table']) && $_GET['table'] == 'college-notifications') {
    
    $catvalue = "college";
    $sql = "SELECT * FROM notifications where category = '" . $catvalue . "'";
    $db->sql($sql);
    $res = $db->getResult();
    
    $bulkData = array();
    
    $rows = array();
    $tempRow = array();

    $currency = $fn->get_settings('currency', false);
    
    foreach ($res as $row) {
        //$operate .= ' <a class="btn btn-xs btn-danger" href="delete-product.php?id=' . $row['product_variant_id'] . '" title="Delete"><i class="fa fa-trash-o"></i></a>&nbsp;';
        
        $operate = ' <a class="btn btn-xs btn-danger" href="delete-product.php?id=' . $row['id'] . '" title="Delete"><i class="fa fa-trash-o"></i> Delete</a>&nbsp;';

        $tempRow['id'] = $row['id'];
        $tempRow['title'] = $row['title'];
        $tempRow['description'] = $row['description'];
        $tempRow['link'] = $row['meetlink'];
        
        $tempRow['image'] = "<a data-lightbox='product' href='" . $row['image'] . "' data-caption='" . $row['title'] . "'><img src='" . $row['image'] . "' title='" . $row['title'] . "' height='50' /></a>";
        
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}
if (isset($_GET['table']) && $_GET['table'] == 'hostel-notifications') {
    
    $catvalue = "hostel";
    $sql = "SELECT * FROM notifications where category = '" . $catvalue . "'";
    $db->sql($sql);
    $res = $db->getResult();
    
    $bulkData = array();
    
    $rows = array();
    $tempRow = array();

    $currency = $fn->get_settings('currency', false);
    
    foreach ($res as $row) {
        //$operate .= ' <a class="btn btn-xs btn-danger" href="delete-product.php?id=' . $row['product_variant_id'] . '" title="Delete"><i class="fa fa-trash-o"></i></a>&nbsp;';
        
        $operate = ' <a class="btn btn-xs btn-danger" href="delete-product.php?id=' . $row['id'] . '" title="Delete"><i class="fa fa-trash-o"></i> Delete</a>&nbsp;';

        $tempRow['id'] = $row['id'];
        $tempRow['title'] = $row['title'];
        $tempRow['description'] = $row['description'];
        $tempRow['link'] = $row['meetlink'];
        
        $tempRow['image'] = "<a data-lightbox='product' href='" . $row['image'] . "' data-caption='" . $row['title'] . "'><img src='" . $row['image'] . "' title='" . $row['title'] . "' height='50' /></a>";
        
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}



$db->disconnect();
