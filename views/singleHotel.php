<?php

require_once '../config.php';

if(!empty($_GET['id']))
{
    $sql = "SELECT * FROM hotel WHERE id = ".$_GET['id'];
    $sqlRooms = "SELECT * FROM room where hotel_id = ".$_GET['id'];
    $sqlServices = "SELECT * FROM hotel_service 
    INNER JOIN service ON service_id=service.id
    where hotel_id = ".$_GET['id'];

    $result = sqlsrv_query($link, $sql);
    $hotel = sqlsrv_fetch_object( $result );

    $resultRooms = sqlsrv_query($link, $sqlRooms);
    $room = sqlsrv_fetch_object( $resultRooms );
    $resultServices = sqlsrv_query($link, $sqlServices);
    $service = sqlsrv_fetch_object( $resultServices );
}else{
    
}

$actionLabel = "Info";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hotel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="col-md-12 head">
            <h5>Hotel</h5>
            <?php echo "Addres: ".$hotel->address; ?><br/>
            <?php echo "Description: ".$hotel->description; ?><br/>
            <?php echo "Phone number: ".$hotel->phone_number; ?><br/>
            <a href="addEditHotel.php?id=<?php echo $hotel->id; ?>"class="btn btn-warning">Edit</a>
        </div>
        <div class="col-md-12 head">
            <h5>Rooms</h5>
            <a href="addEditRoom.php?hotel_id=<?php echo $hotel->id; ?>" class="btn btn-success"> New room</a>
        </div>

        <table class="table table-striped table-bordered" >
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Number</th>
                    <th>Floor</th>
                    <th>Add info</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if(!is_null($room)){ $count = 0; do { $count++; ?>
                <tr>
                    <td><?php echo $count; ?></td>
                    <td><?php echo $room->number; ?></td>
                    <td><?php echo $room->floor; ?></td>
                    <td><?php echo $room->additional_info; ?></td>
                    <td>
                    <a href="singleRoom.php?id=<?php echo $room->id; ?>"class="btn btn-info">Info</a>
                    <a href="addEditRoom.php?id=<?php echo $room->id; ?>"class="btn btn-warning">Edit</a>
                    <a href="roomAction.php?action_type=delete&id=<?php echo $room->id; ?>&hotel_id=<?php echo $hotel->id; ?>" class="btn btn-danger" onclick="return confirm('Are you sure to delete?');">Delete</a>
                </td>
                </tr>
                <?php } while($room = sqlsrv_fetch_object( $result ));} else { ?>
                <tr><td colspan="7">No member(s) found...</td></tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="col-md-12 head">
            <h5>Services</h5>
            <a href="addEditHotelService.php?hotel_id=<?php echo $hotel->id; ?>" class="btn btn-success"> New hotel service</a>
        </div>

        <table class="table table-striped table-bordered" >
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>description</th>
                    <th>price</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if(!is_null($service)){ $count = 0; do { $count++; ?>
                <tr>
                    <td><?php echo $count; ?></td>
                    <td><?php echo $service->name; ?></td>
                    <td><?php echo $service->description; ?></td>
                    <td><?php echo $service->price; ?></td>
                    <td>
                    <a href="addEditHotelService.php?id=<?php echo $service->id; ?>&hotel_id=<?php echo $hotel->id; ?>"class="btn btn-warning">Edit</a>
                    <a href="hotelServiceAction.php?action_type=delete&id=<?php echo $service->id; ?>&hotel_id=<?php echo $hotel->id; ?>" class="btn btn-danger" onclick="return confirm('Are you sure to delete?');">Delete</a>
                </td>
                </tr>
                <?php } while($service = sqlsrv_fetch_object( $result ));} else { ?>
                <tr><td colspan="7">No member(s) found...</td></tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php // Close connection
sqlsrv_close($link); ?>