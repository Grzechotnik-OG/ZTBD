<?php

require_once '../config.php';

if(!empty($_GET['id']))
{
    $stayId = $_GET['id'];
    //$sql = "SELECT stay.id, stay.start_date, stay.end_date, room.number, hotel.id AS hotelId, hotel.address, client.name, client.surname
    //FROM (((stay INNER JOIN room ON stay.room_id=room.id)
    //INNER JOIN hotel ON room.hotel_id=hotel.id)
    //INNER JOIN client ON stay.client_id=client.id)
    //where stay.id = ".$_GET['id']."
    //UNION
	//SELECT stay.id, reservation.start_date, reservation.end_date, room.number, hotel.id AS hotelId, hotel.address, client.name, client.surname
    //FROM ((((reservation INNER JOIN room ON reservation.room_id=room.id)
    //INNER JOIN hotel ON room.hotel_id=hotel.id)
    //INNER JOIN client ON reservation.client_id=client.id)
    //INNER JOIN stay ON stay.reservation_id=reservation.id)
    //where stay.id = ".$_GET['id'];
    //$result = sqlsrv_query($link, $sql);
    //$stay = sqlsrv_fetch_object( $result );

    //$sqlHotelServiceStays = "SELECT hotel_service_stay.id, service.name, service.description, hotel_service.price FROM ((hotel_service_stay INNER JOIN hotel_service ON hotel_service.id = hotel_service_stay.hotel_service_id)
    //INNER JOIN service ON service.id=hotel_service.service_id) WHERE hotel_service_stay.stay_id=".$_GET['id'];
    //$resultService = sqlsrv_query($link, $sqlHotelServiceStays);
    //$service = sqlsrv_fetch_object( $resultService );

    $sql = "EXEC dbo.getStay @StayId = ?";
    $stmt = sqlsrv_prepare($link, $sql, array( &$stayId));
    sqlsrv_execute($stmt);
    $stay = sqlsrv_fetch_object( $stmt );

    $sqlHotelServiceStays = "EXEC dbo.getHotelServiceStays @StayId = ?";
    $stmtService = sqlsrv_prepare($link, $sqlHotelServiceStays, array( &$stayId ));
    sqlsrv_execute($stmtService);
    $service = sqlsrv_fetch_object( $stmtService );
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>client</title>
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
            <h5>Stay</h5>
            <?php echo "Start date: ".$stay->start_date->format('Y-m-d'); ?><br/>
            <?php echo "End date: ".$stay->end_date->format('Y-m-d'); ?><br/>
            <?php echo "Name: ".$stay->name." ". $stay->surname; ?><br/>
            <?php echo "Hotel address: ".$stay->address; ?><br/>
            <?php echo "Room number: ".$stay->number; ?><br/>
        </div>

        <div class="col-md-6">
            <form method="post" action="../actions/hotelServiceStayAction.php">
                <div class="form-group">
                    <label>Service type</label>
                    <select name="service_type" class="form-control">
                    <?php $resType = sqlsrv_query($link, "SELECT hotel_service.id, hotel_service.price, service.name FROM service INNER JOIN hotel_service ON hotel_service.service_id = service.Id WHERE hotel_service.hotel_id = $stay->hotelId");
                        echo '<option value="" selected disabled>Please select</option>';
                        while ($serviceType = sqlsrv_fetch_object($resType))
                        {
                            echo '<option value="'.$serviceType->id.'">Name: '.$serviceType->name.', Price: '.$serviceType->price.'</option>';
                        }
                    ?>
                    </select>
                </div>
                <a href="index.php" class="btn btn-secondary">Back</a>
                <input type="hidden" name="id" value="<?php echo $stay->id; ?>">
                <input type="submit" name="submit" class="btn btn-success" value="Submit">
            </form>
        </div>

        <div class="col-md-12 head">
            <h5>Used services</h5>
        </div>

        <table class="table table-striped table-bordered" >
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
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
                    <a href="../actions/hotelServiceStayAction.php?action_type=delete&id=<?php echo $service->id; ?>&stay_id=<?php echo $stay->id; ?>" class="btn btn-danger" onclick="return confirm('Are you sure to delete?');">Delete</a>
                    </td>
                </tr>
                <?php } while($service = sqlsrv_fetch_object( $stmtService ));} else { ?>
                <tr><td colspan="7">No member(s) found...</td></tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php // Close connection
sqlsrv_close($link); ?>