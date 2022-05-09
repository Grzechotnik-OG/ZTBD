<?php

require_once '../config.php';

if(!empty($_GET['id']))
{
    $sql = "SELECT room.id as room_id, * FROM room 
    inner join hotel on hotel_id = hotel.id
    inner join room_type on room_type_id = room_type.id
    WHERE room.id = ".$_GET['id'];
    $sqlReservations = "SELECT stay.reservation_id AS resId, reservation.id, reservation.start_date, reservation.end_date, room.number, hotel.address, client.name, client.surname
    FROM ((((reservation INNER JOIN room ON reservation.room_id=room.id)
    INNER JOIN hotel ON room.hotel_id=hotel.id)
    INNER JOIN client ON reservation.client_id=client.id)
    LEFT JOIN stay ON reservation.id=stay.reservation_id)
    where reservation.room_id = ".$_GET['id']." Order BY room.hotel_id";
    $sqlStays = "SELECT stay.id, stay.start_date, stay.end_date, room.number, hotel.address, client.name, client.surname
    FROM (((stay INNER JOIN room ON stay.room_id=room.id)
    INNER JOIN hotel ON room.hotel_id=hotel.id)
    INNER JOIN client ON stay.client_id=client.id)
    where room_id = ".$_GET['id']."
    UNION
	SELECT stay.id, reservation.start_date, reservation.end_date, room.number, hotel.address, client.name, client.surname
    FROM ((((reservation INNER JOIN room ON reservation.room_id=room.id)
    INNER JOIN hotel ON room.hotel_id=hotel.id)
    INNER JOIN client ON reservation.client_id=client.id)
    INNER JOIN stay ON stay.reservation_id=reservation.id)
    where reservation.room_id = ".$_GET['id'];
    $result = sqlsrv_query($link, $sql);
    $room = sqlsrv_fetch_object( $result );

    $resultReservations = sqlsrv_query($link, $sqlReservations);
    $reservation = sqlsrv_fetch_object( $resultReservations );
    $resultStays = sqlsrv_query($link, $sqlStays);
    $stay = sqlsrv_fetch_object( $resultStays );
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
            <h5>room</h5>
            <?php echo "Number: ".$room->number; ?><br/>
            <?php echo "Address: ".$room->address; ?><br/>
            <?php echo "floor: ".$room->floor; ?><br/>
            <?php echo "Add Info: ".$room->additional_info; ?><br/>
            <?php echo "people number: ".$room->people; ?><br/>
            <?php echo "beds: ".$room->beds; ?><br/>
            <?php echo "price: ".$room->price; ?><br/>


            <a href="addEditRoom.php?id=<?php echo $room->id; ?>"class="btn btn-warning">Edit</a>
        </div>
        <div class="col-md-12 head">
            <h5>reservations</h5>
            <a href="addEditReservation.php?room_id=<?php echo $room->room_id; ?>" class="btn btn-success"> New Reservation</a>

        </div>

        <table class="table table-striped table-bordered" >
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Checked</th>
                    <th>Start date</th>
                    <th>End date</th>
                    <th>Client</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if(!is_null($reservation)){ $count = 0; do { $count++; ?>
                <tr>
                    <td><?php echo $count; ?></td>
                    <td><?php if(isset($reservation->resId)){echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-check-square-fill" viewBox="0 0 16 16">
                        <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z"/>
                        </svg>';} ?></td>
                    <td><?php echo $reservation->start_date->format('Y-m-d'); ?></td>
                    <td><?php echo $reservation->end_date->format('Y-m-d'); ?></td>
                    <td><?php echo $reservation->name; ?> <?php echo $reservation->surname; ?></td>
                    <td>
                    <a href="addEditReservation.php?id=<?php echo $reservation->id; ?>"class="btn btn-warning">Edit</a>
                    <a href="../actions/reservationAction.php?action_type=delete&id=<?php echo $reservation->id; ?>" class="btn btn-danger" onclick="return confirm('Are you sure to delete?');">Delete</a>
                    <a href="../actions/stayAction.php?action_type=addReservationStay&reservation_id=<?php echo $reservation->id; ?>&&room_id=<?php echo $room->room_id; ?>" class="btn btn-success">Potwierdź pobyt</a>
                </td>
                </tr>
                <?php } while($reservation = sqlsrv_fetch_object( $resultReservations ));} else { ?>
                <tr><td colspan="7">No member(s) found...</td></tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="col-md-12 head">
            <h5>Pobyty</h5>
            <a href="addEditStay.php?room_id=<?php echo $room->room_id; ?>" class="btn btn-success"> New Stay</a>
        </div>

        <table class="table table-striped table-bordered" >
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Start date</th>
                    <th>End date</th>
                    <th>Client</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if(!is_null($stay)){ $count = 0; do { $count++; ?>
                <tr>
                    <td><?php echo $count; ?></td>
                    <td><?php echo $stay->start_date->format('Y-m-d'); ?></td>
                    <td><?php echo $stay->end_date->format('Y-m-d'); ?></td>
                    <td><?php echo $stay->name; ?> <?php echo $stay->surname; ?></td>
                    <td>
                    <a href="singleStay.php?id=<?php echo $stay->id; ?>"class="btn btn-warning">Info</a>
                    <a href="../actions/stayAction.php?action_type=delete&id=<?php echo $stay->id; ?>" class="btn btn-danger" onclick="return confirm('Are you sure to delete?');">Delete</a>
                </td>
                </tr>
                <?php } while($stay = sqlsrv_fetch_object( $resultStays ));} else { ?>
                <tr><td colspan="7">No member(s) found...</td></tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php // Close connection
sqlsrv_close($link); ?>