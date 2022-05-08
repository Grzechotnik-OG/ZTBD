<?php

require_once '../config.php';

if(!empty($_GET['id']))
{
    $sql = "SELECT * FROM reservation WHERE id = ".$_GET['id'];
    $result = sqlsrv_query($link, $sql);
    $reservation = sqlsrv_fetch_object( $result );
}

$actionLabel = !empty($_GET['id'])?'Edit':'Add';

?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<div class="row">
    <div class="col-md-12">
        <h2><?php echo $actionLabel; ?> reservation</h2>
    </div>
    <div class="col-md-6">
         <form method="post" action="../actions/reservationAction.php">
            <div class="form-group">
                <label>Start date</label>
                <input type="date" class="form-control" name="start_date" placeholder="Enter start date" value="<?php echo !empty($reservation->start_date)?$reservation->start_date->format('Y-m-d'):''; ?>" required="">
            </div>
            <div class="form-group">
                <label>End date</label>
                <input type="date" class="form-control" name="end_date" placeholder="Enter end date" value="<?php echo !empty($reservation->end_date)?$reservation->end_date->format('Y-m-d'):''; ?>" required="">
            </div>
            <div class="form-group">
                <label>Client</label>
                <select name="client" class="form-control">
                <?php $resClient = sqlsrv_query($link, "SELECT id, name, surname, phone_number FROM client");
                    echo '<option value="" selected disabled>Please select</option>';
                    $selected="";
                    while ($client = sqlsrv_fetch_object($resClient))
                    {
                        if($reservation->client_id == $client->id) $selected="selected='selected'";
                        echo '<option value="'.$client->id.'"'.$selected.'>'.$client->name.' '.$client->surname.' '.$client->phone_number.'</option>';
                        $selected="";
                    }
                ?>
                </select>
            </div>
            <div class="form-group">
                <label>Room</label>
                <select name="room" class="form-control">
                <?php $resRoom = sqlsrv_query($link, "SELECT room.id, room.number, hotel.address FROM room INNER JOIN hotel ON room.hotel_id=hotel.id ORDER BY hotel.id");
                    echo '<option value="" selected disabled>Please select</option>';
                    $selected="";
                    while ($room = sqlsrv_fetch_object($resRoom))
                    {
                        if($reservation->room_id == $room->id) $selected="selected='selected'";
                        echo '<option value="'.$room->id.'"'.$selected.'>'.$room->address.' Room Number: '.$room->number.'</option>';
                        $selected="";
                    }
                ?>
                </select>
            </div>
            <a href="index.php" class="btn btn-secondary">Back</a>
            <input type="hidden" name="id" value="<?php echo !empty($reservation->id)?$reservation->id:''; ?>">
            <input type="submit" name="submit" class="btn btn-success" value="Submit">
        </form>
    </div>
</div>
