<?php

require_once '../config.php';

$redirectURL = '../index.php';

if(isset($_POST['submit'])){
    $stayId = $_POST['id'];
    $hotelServiceId = trim(strip_tags($_POST['service_type']));

    $sql = "INSERT INTO hotel_service_stay (hotel_service_id, stay_id)
        VALUES ('$hotelServiceId','$stayId')";
    $result = sqlsrv_query($link, $sql);

    $redirectURL = '../views/singleStay.php?id='.$stayId;
}
if (($_REQUEST['action_type'] == 'delete') && !empty($_GET['id']) && !empty($_GET['stay_id']))
{
    $id = $_GET['id'];
    $stayId = $_GET['stay_id'];
    $sql = "DELETE FROM hotel_service_stay WHERE id = ".$id;
    $result = sqlsrv_query($link, $sql);
    $redirectURL = '../views/singleStay.php?id='.$stayId;
}
header("Location:".$redirectURL);
exit();
?>