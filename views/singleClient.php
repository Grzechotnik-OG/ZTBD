<?php

require_once '../config.php';

if(!empty($_GET['id']))
{
    $sql = "SELECT * FROM client WHERE id = ".$_GET['id'];
    $sqlReservations = "SELECT reservation.id, reservation.start_date, reservation.end_date, room.number, hotel.address, client.name, client.surname
        FROM (((reservation INNER JOIN room ON reservation.room_id=room.id)
        INNER JOIN hotel ON room.hotel_id=hotel.id)
        INNER JOIN client ON reservation.client_id=client.id)
        where client_id = ".$_GET['id']." Order BY room.hotel_id";
    $sqlstays = "SELECT stay.id, stay.start_date, stay.end_date, room.number, hotel.address, client.name, client.surname
        FROM (((stay INNER JOIN room ON stay.room_id=room.id)
        INNER JOIN hotel ON room.hotel_id=hotel.id)
        INNER JOIN client ON stay.client_id=client.id)
        where client_id = ".$_GET['id']." Order BY room.hotel_id";

    $sqlServicePrice = "SELECT SUM(hotel_service.price) AS price 
        FROM stay 
        INNER JOIN hotel_service_stay ON hotel_service_stay.stay_id = stay.id 
        INNER JOIN hotel_service ON hotel_service.id = hotel_service_id 
        WHERE client_id = ".$_GET['id'];
    $sqlRoomPrice = "SELECT sum(room_type.price) AS price 
        FROM stay 
        INNER JOIN room ON room_id = room.id 
        INNER JOIN room_type ON room.room_type_id = room_type.id 
        WHERE client_id = ".$_GET['id'];
    $result = sqlsrv_query($link, $sql);
    $client = sqlsrv_fetch_object( $result );

    $resultReservations = sqlsrv_query($link, $sqlReservations);
    $reservation = sqlsrv_fetch_object( $resultReservations );
    $resultstays = sqlsrv_query($link, $sqlstays);
    $stay = sqlsrv_fetch_object( $resultstays );
    $resultServicePrice = sqlsrv_query($link, $sqlServicePrice);
    $servicePrice = sqlsrv_fetch_object( $resultServicePrice );
    $resultRoomPrice = sqlsrv_query($link, $sqlRoomPrice);
    $roomPrice = sqlsrv_fetch_object( $resultRoomPrice );
}else{
    
}

$actionLabel = "Info";

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
            <h5>client</h5>
            <?php echo "Name: ".$client->name." ".$client->surname; ?><br/>
            <?php echo "Addres: ".$client->address; ?><br/>
            <?php echo "Phone number: ".$client->phone_number; ?><br/>
            <?php echo "Rachunek: ".$servicePrice->price + $roomPrice->price - $client->registered_payment; ?><br/>
            <a href="addEditClient.php?id=<?php echo $client->id; ?>"class="btn btn-warning">Edit</a>
        </div>
        <div class="col-md-12 head">
            <h5>reservations</h5>
            <a href="addEditReservation.php?client_id=<?php echo $client->id; ?>" class="btn btn-success"> New Reservation</a>
        </div>

        <table class="table table-striped table-bordered" >
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Start date</th>
                    <th>End date</th>
                    <th>Room number</th>
                    <th>Hotel</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if(!is_null($reservation)){ $count = 0; do { $count++; ?>
                <tr>
                    <td><?php echo $count; ?></td>
                    <td><?php echo $reservation->start_date->format('Y-m-d'); ?></td>
                    <td><?php echo $reservation->end_date->format('Y-m-d'); ?></td>
                    <td><?php echo $reservation->number; ?></td>
                    <td><?php echo $reservation->address; ?></td>
                    <td>
                    <a href="addEditReservation.php?id=<?php echo $reservation->id; ?>"class="btn btn-warning">Edit</a>
                    <a href="../actions/reservationAction.php?action_type=delete&id=<?php echo $reservation->id; ?>" class="btn btn-danger" onclick="return confirm('Are you sure to delete?');">Delete</a>
                </td>
                </tr>
                <?php } while($reservation = sqlsrv_fetch_object( $result ));} else { ?>
                <tr><td colspan="7">No member(s) found...</td></tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="col-md-12 head">
            <h5>pobyty</h5>
            <a href="addEditStay.php?client_id=<?php echo $client->id; ?>" class="btn btn-success"> New Stay</a>
        </div>

        <table class="table table-striped table-bordered" >
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Start date</th>
                    <th>End date</th>
                    <th>Room number</th>
                    <th>Hotel</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if(!is_null($stay)){ $count = 0; do { $count++; ?>
                <tr>
                    <td><?php echo $count; ?></td>
                    <td><?php echo $stay->start_date->format('Y-m-d'); ?></td>
                    <td><?php echo $stay->end_date->format('Y-m-d'); ?></td>
                    <td><?php echo $stay->number; ?></td>
                    <td><?php echo $stay->address; ?></td>
                    <td>
                    <a href="addEditstay.php?id=<?php echo $stay->id; ?>"class="btn btn-warning">Edit</a>
                    <a href="../actions/stayAction.php?action_type=delete&id=<?php echo $stay->id; ?>" class="btn btn-danger" onclick="return confirm('Are you sure to delete?');">Delete</a>
                </td>
                </tr>
                <?php } while($stay = sqlsrv_fetch_object( $result ));} else { ?>
                <tr><td colspan="7">No member(s) found...</td></tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php // Close connection
sqlsrv_close($link); ?>