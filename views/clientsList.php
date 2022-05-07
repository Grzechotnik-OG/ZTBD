<?php
// Include config file
require_once "../config.php";

// Prepare a select statement
$sql = "SELECT * FROM client";

$result = sqlsrv_query($link, $sql);

if($result !== false)
{
    $client = sqlsrv_fetch_object( $result );
}
else{
    echo "Oops! Something went wrong. Please try again later.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>clients</title>
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
            <h5>clients</h5>
            <a href="addEditclient.php" class="btn btn-success"> New client</a>
        </div>

        <table class="table table-striped table-bordered" >
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>name</th>
                    <th>email</th>
                    <th>address</th>
                    <th>phone number</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if(!is_null($client)){ $count = 0; do { $count++; ?>
                <tr>
                    <td><?php echo $count; ?></td>
                    <td><?php echo $client->name; ?> <?php echo $client->surname; ?></td>
                    <td><?php echo $client->email; ?></td>
                    <td><?php echo $client->address; ?></td>
                    <td><?php echo $client->phone_number; ?></td>
                    <td>
                    <a href="addEditClient.php?id=<?php echo $client->id; ?>"class="btn btn-warning">Edit</a>
                    <a href="singleclient.php?id=<?php echo $client->id; ?>"class="btn btn-info">Info</a>
                    <a href="clientAction.php?action_type=delete&id=<?php echo $client->id; ?>" class="btn btn-danger" onclick="return confirm('Are you sure to delete?');">Delete</a>
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