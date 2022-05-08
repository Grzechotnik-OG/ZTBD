<?php

require_once '../config.php';

$redirectURL = '../index.php';

if(isset($_POST['submit'])){
    $id = $_POST['id'];
    $price = trim(strip_tags($_POST['price']));
    $floor = trim(strip_tags($_POST['floor']));
    $info = trim(strip_tags($_POST['info']));
    $hotel = trim(strip_tags($_POST['hotel']));
    $service = trim(strip_tags($_POST['service']));
    $idStr = '';
    if(!empty($id))
    {
        $idStr = '?id='.$id;

        $sql = "UPDATE hotel_service SET price = '$price',
            hotel_id = '$hotel', service_id = '$service' WHERE id = ".$id;
        $result = sqlsrv_query($link, $sql);
        if($result === false)
        {
            $redirectURL = '../views/addEditHotelService.php'.$idStr;
        }
    }
    else
    {
        $sql = "INSERT INTO hotel_service (price, hotel_id, service_id)
            VALUES ('$price','$hotel','$service')";
        $result = sqlsrv_query($link, $sql);
        if($result === false)
        {
            $redirectURL = '../views/addEditHotelService.php';
        }
    }
}
if (($_REQUEST['action_type'] == 'delete') && !empty($_GET['id']))
{
    $id = $_GET['id'];
    $sql = "DELETE FROM hotel_service WHERE id = ".$id;
    $result = sqlsrv_query($link, $sql);
}
header("Location:".$redirectURL);
exit();
?>