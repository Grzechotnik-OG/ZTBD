<?php

require_once 'config.php';

$redirectURL = 'index.php';

if(isset($_POST['submit'])){
    $id = $_POST['id'];
    $number = trim(strip_tags($_POST['number']));
    $floor = trim(strip_tags($_POST['floor']));
    $id_str = '';

    if(!empty($id)){
        $id_str = '?id='.$id;
    }

    if(!empty($id))
    {
        $sql = "UPDATE room SET number = ".$number.", floor = ".$floor." WHERE id = ".$id;
        $result = sqlsrv_query($link, $sql);
        if($result === false)
        {
            $redirectURL = 'addEdit.php'.$id_str;
        }
    }
    else
    {
        $sql = "INSERT INTO room (number, floor, hotel_id, room_type_id) VALUES (".$number.",".$floor.",1,1)";
        $result = sqlsrv_query($link, $sql);
        if($result === false)
        {
            $redirectURL = 'addEdit.php';
        }
    }
}
header("Location:".$redirectURL);
exit();
?>