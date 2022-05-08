<?php

require_once '../config.php';

if(!empty($_GET['id']))
{
    $sql = "SELECT * FROM hotel_service WHERE id = ".$_GET['id'];
    $result = sqlsrv_query($link, $sql);
    $hotelService = sqlsrv_fetch_object( $result );
}

$actionLabel = !empty($_GET['id'])?'Edit':'Add';

?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<div class="row">
    <div class="col-md-12">
        <h2><?php echo $actionLabel; ?> hotelService</h2>
    </div>
    <div class="col-md-6">
         <form method="post" action="../actions/hotelServiceAction.php">
            <div class="form-group">
                <label>price</label>
                <input type="text" class="form-control" name="price" placeholder="Enter price" value="<?php echo !empty($hotelService->price)?$hotelService->price:''; ?>" required="">
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
                        if($hotelService->hotel_id == $hotel->id || $_GET['hotel_id'] == $hotel->id) $selected="selected='selected'";
                        echo '<option value="'.$hotel->id.'"'.$selected.'>'.$hotel->address.'</option>';
                        $selected="";
                    }
                ?>
                </select>
            </div>
            <div class="form-group">
                <label>Service</label>
                <select name="service" class="form-control">
                <?php
                    if (!empty($_GET['service_id']))
                    {
                        $resService = sqlsrv_query($link, "SELECT * FROM service where id =".$_GET['service_id']);
                    }else{
                        $resService = sqlsrv_query($link, "SELECT * FROM service");
                        echo '<option value="" selected disabled>Please select</option>';
                    }
                    $selected="";
                    while ($Service = sqlsrv_fetch_object($resService))
                    {
                        if($hotelService->Service_id == $Service->id || $_GET['service_id'] == $Service->id) $selected="selected='selected'";
                        echo '<option value="'.$Service->id.'"'.$selected.'>'.$Service->name.'</option>';
                        $selected="";
                    }
                ?>
                </select>
            </div>
            <a href="index.php" class="btn btn-secondary">Back</a>
            <input type="hidden" name="id" value="<?php echo !empty($hotelService->id)?$hotelService->id:''; ?>">
            <input type="submit" name="submit" class="btn btn-success" value="Submit">
        </form>
    </div>
</div>