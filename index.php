<?php
// Include config file
require_once "config.php";

// Prepare a select statement
$sql = "SELECT * FROM room";

$result = sqlsrv_query($link, $sql);

if($result !== false)
{
    $room = sqlsrv_fetch_object( $result );
}
else{
    echo "Oops! Something went wrong. Please try again later.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rooms</title>
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
            <h5>System do zarzadzania siecią hoteli</h5>
            <a href="views/hotelsList.php" class="btn btn-info">Hotele</a>
            <a href="views/clientsList.php" class="btn btn-info">Klienci</a>
            <a href="views/servicesList.php" class="btn btn-info">Usługi</a>
            <a href="views/reservationsList.php" class="btn btn-info">Rezerwacje</a>
        </div>
    </div>
</body>
</html>

<?php // Close connection
sqlsrv_close($link); ?>