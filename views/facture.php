<?php

require_once '../config.php';

if(!empty($_GET['id']))
{
    $clientId = $_GET['id'];

    $sql = "EXEC dbo.getClient @ClientId = ?";
    $stmt = sqlsrv_prepare($link, $sql, array( &$clientId));
    sqlsrv_execute($stmt);
    $client = sqlsrv_fetch_object( $stmt );

    $sql = "EXEC dbo.getStaysByClientId @ClientId = ?";
    $stmtStays = sqlsrv_prepare($link, $sql, array( &$clientId));
    sqlsrv_execute($stmtStays);
    $stay = sqlsrv_fetch_object( $stmtStays );

    $sql = "EXEC dbo.getServicesPrice @ClientId = ?";
    $stmt = sqlsrv_prepare($link, $sql, array( &$clientId));
    sqlsrv_execute($stmt);
    $servicePrice = sqlsrv_fetch_object( $stmt );

    $sql = "EXEC dbo.getRoomsPrice @ClientId = ?";
    $stmt = sqlsrv_prepare($link, $sql, array( &$clientId));
    sqlsrv_execute($stmt);
    $roomPrice = sqlsrv_fetch_object( $stmt );

    $sql = "EXEC dbo.getStayPriceByReservationId @ClientId = ?";
    $stmt = sqlsrv_prepare($link, $sql, array( &$clientId));
    sqlsrv_execute($stmt);
    $serviceReservationPrice = sqlsrv_fetch_object( $stmt );

    $sql = "EXEC dbo.getRoomPriceByReservationId @ClientId = ?";
    $stmt = sqlsrv_prepare($link, $sql, array( &$clientId));
    sqlsrv_execute($stmt);
    $roomReservationPrice = sqlsrv_fetch_object( $stmt );

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
            <h5>Client</h5>
            <?php echo "Name: ".$client->name." ".$client->surname; ?><br/>
            <?php echo "Address: ".$client->address; ?><br/>
            <?php echo "Phone number: ".$client->phone_number; ?><br/>
            <?php
            $tmp = $servicePrice->price + $roomPrice->price +$serviceReservationPrice->price + $roomReservationPrice->price - $client->registered_payment;
            echo "Reckoning: ".$tmp; ?><br/>
        </div>

        <div class="col-md-12 head">
            <h5>Pobyty</h5>
        </div>

        <table class="table table-striped table-bordered" >
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Start date</th>
                    <th>End date</th>
                    <th>Room number</th>
                    <th>Hotel</th>
                    <th>Room price</th>
                    <th>Used services</th>
                    <th>Total price</th>
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
                    <td><?php echo $stay->price; ?></td>
                    <td><pre><?php
                        $sqlHotelServiceStays = "EXEC dbo.getHotelServiceStays @StayId = ?";
                        $stmtService = sqlsrv_prepare($link, $sqlHotelServiceStays, array( &$stay->id ));
                        sqlsrv_execute($stmtService);
                        $totalPrice = 0;
                        while($service = sqlsrv_fetch_object( $stmtService ))
                        {
                            echo $service->name.' '.$service->price, PHP_EOL;
                            $totalPrice=$totalPrice+$service->price;
                        }
                    ?></pre></td>
                    <td><?php echo $stay->price+$totalPrice; ?></td>
                </tr>
                <?php } while($stay = sqlsrv_fetch_object( $stmtStays ));} else { ?>
                <tr><td colspan="7">No member(s) found...</td></tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>