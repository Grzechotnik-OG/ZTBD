<?php
// Include config file
require_once "../config.php";

// Prepare a select statement
$sql = "SELECT * FROM hotel";

$result = sqlsrv_query($link, $sql);

if($result !== false)
{
    $hotel = sqlsrv_fetch_object( $result );
}
else{
    echo "Oops! Something went wrong. Please try again later.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>hotels</title>
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
            <h5>hotels</h5>
            <a href="addEditHotel.php" class="btn btn-success"> New hotel</a>
        </div>

        <table class="table table-striped table-bordered" >
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>address</th>
                    <th>description</th>
                    <th>phone number</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if(!is_null($hotel)){ $count = 0; do { $count++; ?>
                <tr>
                    <td><?php echo $count; ?></td>
                    <td><?php echo $hotel->address; ?></td>
                    <td><?php echo $hotel->description; ?></td>
                    <td><?php echo $hotel->phone_number; ?></td>
                    <td>
                    <a href="addEditHotel.php?id=<?php echo $hotel->id; ?>"class="btn btn-warning">Edit</a>
                    <a href="singleHotel.php?id=<?php echo $hotel->id; ?>"class="btn btn-info">Info</a>
                    <a href="../actions/hotelAction.php?action_type=delete&id=<?php echo $hotel->id; ?>" class="btn btn-danger" onclick="return confirm('Are you sure to delete?');">Delete</a>
                </td>
                </tr>
                <?php } while($hotel = sqlsrv_fetch_object( $result ));} else { ?>
                <tr><td colspan="7">No member(s) found...</td></tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php // Close connection
sqlsrv_close($link); ?>