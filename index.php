<?php
// echo "<body style = 'background-color: black'>";
// Check existence of id parameter before processing further
// Include config file
require_once "config.php";

// Prepare a select statement
$sql = "SELECT * FROM room";

$result = sqlsrv_query($link, $sql);

if(($result = sqlsrv_query($link, $sql)) !== false)
{
    $obj = sqlsrv_fetch_object( $result );
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
            <h5>Rooms</h5>
            <a class="btn btn-success"><i class="plus"></i> New room</a>
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
                <?php if(!is_null($obj)){ $count = 0; do { $count++; ?>
                <tr>
                    <td><?php echo $count; ?></td>
                    <td><?php echo $obj->number; ?></td>
                    <td><?php echo $obj->floor; ?></td>
                    <td><?php echo $obj->additional_info; ?></td>
                    <td>
                    <a class="btn btn-warning">edit</a>
                    <a class="btn btn-danger" onclick="return confirm('Are you sure to delete?');">delete</a>
                </td>
                </tr>
                <?php } while($obj = sqlsrv_fetch_object( $result ));} else { ?>
                <tr><td colspan="7">No member(s) found...</td></tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php // Close connection
sqlsrv_close($link); ?>