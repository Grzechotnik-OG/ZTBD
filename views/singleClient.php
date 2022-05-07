<?php

require_once '../config.php';

if(!empty($_GET['id']))
{
    $sql = "SELECT * FROM client WHERE id = ".$_GET['id'];
    $sqlReservations = "SELECT * FROM reservation where client_id = ".$_GET['id'];
    $result = sqlsrv_query($link, $sql);
    $client = sqlsrv_fetch_object( $result );

    $resultReservations = sqlsrv_query($link, $sqlReservations);
    $reservations = sqlsrv_fetch_object( $resultReservations );
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
            <?php echo "Addres: ".$client->address; ?><br/>
            <?php echo "Phone number: ".$client->phone_number; ?><br/>
            <a href="addEditClient.php?id=<?php echo $client->id; ?>"class="btn btn-warning">Edit</a>
        </div>
        <div class="col-md-12 head">
            <h5>reservations</h5>
            <!-- <a href="addEditclient.php?client_id=<?php echo $client->id; ?>" class="btn btn-success"> New client</a> -->
        </div>

        <table class="table table-striped table-bordered" >
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>startDate</th>
                    <th>endDate</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if(!is_null($reservations)){ $count = 0; do { $count++; ?>
                <tr>
                    <td><?php echo $count; ?></td>
                    <td><?php echo date_format($reservations->start_date, 'Y-m-d'); ?></td>
                    <td><?php echo date_format($reservations->end_date, 'Y-m-d'); ?></td>
                    <td>
                    <!-- <a href="addEditclient.php?id=<?php echo $client->id; ?>"class="btn btn-warning">Edit</a> -->
                    <!-- <a href="clientAction.php?action_type=delete&id=<?php echo $client->id; ?>&client_id=<?php echo $client->id; ?>" class="btn btn-danger" onclick="return confirm('Are you sure to delete?');">Delete</a> -->
                </td>
                </tr>
                <?php } while($client = sqlsrv_fetch_object( $result ));} else { ?>
                <tr><td colspan="7">No member(s) found...</td></tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php // Close connection
sqlsrv_close($link); ?>