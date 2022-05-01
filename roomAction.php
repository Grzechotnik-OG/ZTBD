<?php

require_once 'config.php';

$redirectURL = 'index.php';

if(isset($_POST['submit'])){
    $id = $_POST['id'];
    $number = trim(strip_tags($_POST['number']));
    $floor = trim(strip_tags($_POST['floor']));
    $info = trim(strip_tags($_POST['info']));
    $hotel = trim(strip_tags($_POST['hotel']));
    $roomType = trim(strip_tags($_POST['room_type']));
    $idStr = '';
    if(!empty($id))
    {
        $idStr = '?id='.$id;

        $sql = "UPDATE room SET number = '$number', floor = '$floor', additional_info = '$info',
            hotel_id = '$hotel', room_type_id = '$roomType' WHERE id = ".$id;
        $result = sqlsrv_query($link, $sql);
        if($result === false)
        {
            $redirectURL = 'addEdit.php'.$idStr;
        }
    }
    else
    {
        $sql = "INSERT INTO room (number, floor, additional_info, hotel_id, room_type_id)
            VALUES ('$number','$floor','$info','$hotel','$roomType')";
        $result = sqlsrv_query($link, $sql);
        if($result === false)
        {
            $redirectURL = 'addEdit.php';
        }
    }
}
if (($_REQUEST['action_type'] == 'delete') && !empty($_GET['id']))
{
    $id = $_GET['id'];
    $sql = "DELETE FROM room WHERE id = ".$id;
    $result = sqlsrv_query($link, $sql);
}
header("Location:".$redirectURL);
exit();
?>