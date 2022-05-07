<?php

require_once '../config.php';

$redirectURL = '../index.php';

if(isset($_POST['submit'])){
    $id = $_POST['id'];
    $address = trim(strip_tags($_POST['address']));
    $description = trim(strip_tags($_POST['description']));
    $phone_number = trim(strip_tags($_POST['phone_number']));
    $idStr = '';
    if(!empty($id))
    {
        $idStr = '?id='.$id;

        $sql = "UPDATE hotel SET address = '$address', description = '$description', phone_number = '$phone_number'
            WHERE id = ".$id;
        $result = sqlsrv_query($link, $sql);
        if($result === false)
        {
            $redirectURL = '../views/addEditHotel.php'.$idStr;
        }
    }
    else
    {
        $sql = "INSERT INTO hotel (address, description, phone_number)
            VALUES ('$address','$description','$phone_number')";
        $result = sqlsrv_query($link, $sql);
        if($result === false)
        {
            $redirectURL = '../views/addEditHotel.php';
        }
    }
}
if (($_REQUEST['action_type'] == 'delete') && !empty($_GET['id']))
{
    $id = $_GET['id'];
    $sql = "DELETE FROM hotel WHERE id = ".$id;
    $result = sqlsrv_query($link, $sql);
}
header("Location:".$redirectURL);
exit();
?>