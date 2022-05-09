<?php

require_once '../config.php';

$redirectURL = '../index.php';

if(isset($_POST['submit']) && isset($_POST['id'])){
    $id = $_POST['id'];
    $address = trim(strip_tags($_POST['address']));
    $name = trim(strip_tags($_POST['name']));
    $surname = trim(strip_tags($_POST['surname']));
    $email = trim(strip_tags($_POST['email']));
    $phone_number = trim(strip_tags($_POST['phone_number']));
    $idStr = '';
    if(!empty($id))
    {
        $idStr = '?id='.$id;

        $sql = "UPDATE client SET address = '$address', name = '$name', email = '$email', 
            surname = '$surname', phone_number = '$phone_number'
            WHERE id = ".$id;
        $result = sqlsrv_query($link, $sql);
        if($result === false)
        {
            $redirectURL = '../views/addEditClient.php'.$idStr;
        }
    }
    else
    {
        $sql = "INSERT INTO client (address, name, surname, email, phone_number)
            VALUES ('$address','$name', '$surname', '$email', '$phone_number')";
        $result = sqlsrv_query($link, $sql);
        if($result === false)
        {
            $redirectURL = '../views/addEditClient.php';
        }
    }
}
else if(isset($_POST['submit']) && isset($_POST['client_id'])){
    $id = $_POST['client_id'];
    $idStr = '?id='.$id;

    $registered_payment = trim(strip_tags($_POST['registered_payment']));
    $new_payment = trim(strip_tags($_POST['new_payment']));
    $tmp = $registered_payment + $new_payment;

    $sql = "UPDATE client SET registered_payment = '$tmp' WHERE id = ".$id;
    $result = sqlsrv_query($link, $sql);
    $redirectURL = '../views/singleClient.php'.$idStr;
}

if (($_REQUEST['action_type'] == 'delete') && !empty($_GET['id']))
{
    $id = $_GET['id'];
    $sql = "DELETE FROM client WHERE id = ".$id;
    $result = sqlsrv_query($link, $sql);
}
header("Location:".$redirectURL);
exit();
?>