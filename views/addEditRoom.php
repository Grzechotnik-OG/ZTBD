<?php

require_once '../config.php';

if(!empty($_GET['id']))
{
    $sql = "SELECT * FROM room WHERE id = ".$_GET['id'];
    $result = sqlsrv_query($link, $sql);
    $room = sqlsrv_fetch_object( $result );
}

$actionLabel = !empty($_GET['id'])?'Edit':'Add';

?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<div class="row">
    <div class="col-md-12">
        <h2><?php echo $actionLabel; ?> room</h2>
    </div>
    <div class="col-md-6">
         <form method="post" action="../actions/roomAction.php">
            <div class="form-group">
                <label>Number</label>
                <input type="text" class="form-control" name="number" placeholder="Enter number" value="<?php echo !empty($room->number)?$room->number:''; ?>" required="">
            </div>
            <div class="form-group">
                <label>Floor</label>
                <input type="text" class="form-control" name="floor" placeholder="Enter floor" value="<?php echo !empty($room->floor)?$room->floor:''; ?>" required="">
            </div>
            <div class="form-group">
                <label>Additional information</label>
                <input type="text" class="form-control" name="info" placeholder="Enter information" value="<?php echo !empty($room->additional_info)?$room->additional_info:''; ?>">
            </div>
            <div class="form-group">
                <label>Hotel</label>
                <select name="hotel" class="form-control">
                <?php
                    if (!empty($_GET['hotel_id']))
                    {
                        $resHotel = sqlsrv_query($link, "SELECT * FROM hotel where id =".$_GET['hotel_id']);
                    }else{
                        $resHotel = sqlsrv_query($link, "SELECT * FROM hotel");
                        echo '<option value="" selected disabled>Please select</option>';
                    }
                    $selected="";
                    while ($hotel = sqlsrv_fetch_object($resHotel))
                    {
                        if($room->hotel_id == $hotel->id || $_GET['hotel_id'] == $hotel->id) $selected="selected='selected'";
                        echo '<option value="'.$hotel->id.'"'.$selected.'>'.$hotel->address.'</option>';
                        $selected="";
                    }
                ?>
                </select>
            </div>
            <div class="form-group">
                <label>Room type</label>
                <select name="room_type" class="form-control">
                <?php $resType = sqlsrv_query($link, "SELECT * FROM room_type");
                    echo '<option value="" selected disabled>Please select</option>';
                    $selected="";
                    while ($roomType = sqlsrv_fetch_object($resType))
                    {
                        if($room->room_type_id == $roomType->id) $selected="selected='selected'";
                        echo '<option value="'.$roomType->id.'"'.$selected.'>People: '.$roomType->people.', Beds: '.$roomType->beds.', Price: '.$roomType->price.'</option>';
                        $selected="";
                    }
                ?>
                </select>
            </div>
            <a href="index.php" class="btn btn-secondary">Back</a>
            <input type="hidden" name="id" value="<?php echo !empty($room->id)?$room->id:''; ?>">
            <input type="submit" name="submit" class="btn btn-success" value="Submit">
        </form>
    </div>
</div>