<?php

require_once '../config.php';

if(!empty($_GET['id']))
{
    $sql = "SELECT * FROM stay WHERE id = ".$_GET['id'];
    $result = sqlsrv_query($link, $sql);
    $stay = sqlsrv_fetch_object( $result );
}

$actionLabel = !empty($_GET['id'])?'Edit':'Add';

?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<div class="row">
    <div class="col-md-12">
        <h2><?php echo $actionLabel; ?> stay</h2>
    </div>
    <div class="col-md-6">
         <form method="post" action="../actions/stayAction.php">
            <div class="form-group">
                <label>Start date</label>
                <input type="date" class="form-control" name="start_date" placeholder="Enter start date" value="<?php echo !empty($stay->start_date)?$stay->start_date->format('Y-m-d'):''; ?>" required="">
            </div>
            <div class="form-group">
                <label>End date</label>
                <input type="date" class="form-control" name="end_date" placeholder="Enter end date" value="<?php echo !empty($stay->end_date)?$stay->end_date->format('Y-m-d'):''; ?>" required="">
            </div>
            <div class="form-group">
                <label>Client</label>
                <select name="client" class="form-control">
                <?php 
                    if (!empty($_GET['client_id']))
                    {
                        $resClient = sqlsrv_query($link, "SELECT id, name, surname, phone_number FROM client
                            WHERE id=".$_GET['client_id']);
                    }else{
                        $resClient = sqlsrv_query($link, "SELECT id, name, surname, phone_number FROM client");
                        echo '<option value="" selected disabled>Please select</option>';
                    }
                    $selected="";
                    while ($client = sqlsrv_fetch_object($resClient))
                    {
                        if($stay->client_id == $client->id) $selected="selected='selected'";
                        echo '<option value="'.$client->id.'"'.$selected.'>'.$client->name.' '.$client->surname.' '.$client->phone_number.'</option>';
                        $selected="";
                    }
                ?>
                </select>
            </div>
            <div class="form-group">
                <label>Room</label>
                <select name="room" class="form-control">
                <?php 
                
                    if (!empty($_GET['room_id']))
                    {
                        $resRoom = sqlsrv_query($link, "SELECT room.id, room.number, hotel.address FROM room INNER JOIN hotel ON room.hotel_id=hotel.id Where room.id=".$_GET['room_id']);
                    }else{
                        $resRoom = sqlsrv_query($link, "SELECT room.id, room.number, hotel.address FROM room INNER JOIN hotel ON room.hotel_id=hotel.id ORDER BY hotel.id");
                        echo '<option value="" selected disabled>Please select</option>';
                    }
                    $selected="";
                    while ($room = sqlsrv_fetch_object($resRoom))
                    {
                        if($stay->room_id == $room->id) $selected="selected='selected'";
                        echo '<option value="'.$room->id.'"'.$selected.'>'.$room->address.' Room Number: '.$room->number.'</option>';
                        $selected="";
                    }
                ?>
                </select>
            </div>
            <a href="index.php" class="btn btn-secondary">Back</a>
            <input type="hidden" name="id" value="<?php echo !empty($stay->id)?$stay->id:''; ?>">
            <input type="submit" name="submit" class="btn btn-success" value="Submit">
        </form>
    </div>
</div>
