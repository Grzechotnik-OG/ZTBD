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

        //$sql = "UPDATE client SET address = '$address', name = '$name', email = '$email', 
        //    surname = '$surname', phone_number = '$phone_number'
        //    WHERE id = ".$id;
        //$result = sqlsrv_query($link, $sql);
        //if($result === false)
        //{
        //    $redirectURL = '../views/addEditClient.php'.$idStr;
        //}
        $sql = "EXEC dbo.updateClient @Address = ?, @Name= ?, @Surname= ?, @Email= ?, @PhoneNumber= ?, @ClientId = ?";
        $stmt = sqlsrv_prepare($link, $sql, array( &$address, &$name, &$surname, &$email, &$phone_number, &$id ));
        if(!sqlsrv_execute($stmt))
        {
            $redirectURL = '../views/addEditClient.php'.$idStr;
        }

    }
    else
    {
       //$sql = "INSERT INTO client (address, name, surname, email, phone_number)
       //    VALUES ('$address','$name', '$surname', '$email', '$phone_number')";
       //$result = sqlsrv_query($link, $sql);
       //if($result === false)
       //{
       //    $redirectURL = '../views/addEditClient.php';
       //}

        $sql = "EXEC dbo.addClient @Address = ?, @Name= ?, @Surname= ?, @Email= ?, @PhoneNumber= ?";
        $stmt = sqlsrv_prepare($link, $sql, array( &$address, &$name, &$surname, &$email, &$phone_number ));
        if(!sqlsrv_execute($stmt))
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
    $sql = "EXEC dbo.deleteClient @ClientId = ?";
    $stmt = sqlsrv_prepare($link, $sql, array( &$_GET['id']));
    sqlsrv_execute($stmt);
}
header("Location:".$redirectURL);
exit();
?>