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

        $sql = "UPDATE stay SET start_date = '$start', end_date = '$end', client_id = '$client',
            room_id = '$room' WHERE id = ".$id;
        $result = sqlsrv_query($link, $sql);
        if($result === false)
        {
            $redirectURL = '../views/addEditStay.php'.$idStr;
        }
    }
    else
    {
        $sql = "INSERT INTO stay (start_date, end_date, client_id, room_id)
            VALUES ('$start','$end','$client','$room')";
        $result = sqlsrv_query($link, $sql);
        if($result === false)
        {
            $redirectURL = '../views/addEditStay.php';
        }
    }
}
if (($_REQUEST['action_type'] == 'delete') && !empty($_GET['id']))
{
    $id = $_GET['id'];
    $sql = "DELETE FROM stay WHERE id = ".$id;
    $result = sqlsrv_query($link, $sql);
}
if (($_REQUEST['action_type'] == 'addReservationStay') && !empty($_GET['reservation_id']))
{
    $reservationId = $_GET['reservation_id'];
    if(!empty($_GET['room_id'])){
        $returnId = $_GET['room_id'];
        $redirectURL = '../views/singleRoom.php?id='.$returnId;
    }
    else{
        $returnId = $_GET['client_id'];
        $redirectURL = '../views/singleClient.php?id='.$returnId;
    }
    $sql = "INSERT INTO stay (reservation_id)
            VALUES ('$reservationId')";
    $result = sqlsrv_query($link, $sql);
}
header("Location:".$redirectURL);
exit();
?>