<?php
// Include config file
require_once "../config.php";

// Prepare a select statement
$sql = "SELECT reservation.id, reservation.start_date, reservation.end_date, room.number, hotel.address, client.name, client.surname
    FROM (((reservation INNER JOIN room ON reservation.room_id=room.id)
    INNER JOIN hotel ON room.hotel_id=hotel.id)
    INNER JOIN client ON reservation.client_id=client.id)Order BY room.hotel_id";

$result = sqlsrv_query($link, $sql);

if($result !== false)
{
    $reservation = sqlsrv_fetch_object( $result );
}
else{
    echo "Oops! Something went wrong. Please try again later.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reservations</title>
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
            <h5>Reservations</h5>
            <a href="addEditReservation.php" class="btn btn-success">New reservation</a>
        </div>

        <table class="table table-striped table-bordered" >
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Start date</th>
                    <th>End date</th>
                    <th>Room number</th>
                    <th>Hotel</th>
                    <th>Client name</th>
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
                    <td><?php echo $reservation->name; ?> <?php echo $reservation->surname; ?></td>
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
    </div>
</body>
</html>

<?php // Close connection
sqlsrv_close($link); ?>