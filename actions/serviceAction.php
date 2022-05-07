<?php

require_once '../config.php';

$redirectURL = '../index.php';

if(isset($_POST['submit'])){
    $id = $_POST['id'];
    $name = trim(strip_tags($_POST['name']));
    $description = trim(strip_tags($_POST['description']));
    $idStr = '';
    if(!empty($id))
    {
        $idStr = '?id='.$id;

        $sql = "UPDATE service SET name = '$name', description = '$description' WHERE id = ".$id;
        $result = sqlsrv_query($link, $sql);
        if($result === false)
        {
            $redirectURL = 'addEditService.php'.$idStr;
        }
    }
    else
    {
        $sql = "INSERT INTO service (name, description)
            VALUES ('$name','$description')";
        $result = sqlsrv_query($link, $sql);
        if($result === false)
        {
            $redirectURL = 'addEditService.php';
        }
    }
}
if (($_REQUEST['action_type'] == 'delete') && !empty($_GET['id']))
{
    $id = $_GET['id'];
    $sql = "DELETE FROM service WHERE id = ".$id;
    $result = sqlsrv_query($link, $sql);
}
header("Location:".$redirectURL);
exit();
?>