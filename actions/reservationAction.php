<?php

require_once '../config.php';

$redirectURL = '../index.php';

if(isset($_POST['submit'])){
    $id = $_POST['id'];
    $start = trim(strip_tags($_POST['start_date']));
    $end = trim(strip_tags($_POST['end_date']));
    $client = trim(strip_tags($_POST['client']));
    $room = trim(strip_tags($_POST['room']));
    $idStr = '';
    if(!empty($id))
    {
        $idStr = '?id='.$id;

        $sql = "UPDATE reservation SET start_date = '$start', end_date = '$end', client_id = '$client',
            room_id = '$room' WHERE id = ".$id;
        $result = sqlsrv_query($link, $sql);
        if($result === false)
        {
            $redirectURL = '../views/addEditReservation.php'.$idStr;
        }
    }
    else
    {
        $sql = "INSERT INTO reservation (start_date, end_date, client_id, room_id)
            VALUES ('$start','$end','$client','$room')";
        $result = sqlsrv_query($link, $sql);
        if($result === false)
        {
            $redirectURL = '../views/addEditReservation.php';
        }
    }
}
if (($_REQUEST['action_type'] == 'delete') && !empty($_GET['id']))
{
    $id = $_GET['id'];
    $sql = "DELETE FROM reservation WHERE id = ".$id;
    $result = sqlsrv_query($link, $sql);
}
header("Location:".$redirectURL);
exit();
?>