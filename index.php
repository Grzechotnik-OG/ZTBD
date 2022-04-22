<?php
echo "<body style = 'background-color: black'>";
// Check existence of id parameter before processing further
    // Include config file
require_once "config.php";

// Prepare a select statement
$sql = "SELECT * FROM room";

if(($result = sqlsrv_query($link, $sql)) !== false){
    while( $obj = sqlsrv_fetch_object( $result )) {
        foreach($obj as $key => $value) {
            print "$value";
        }
        echo '<br />';
    }

} else{
    echo "Oops! Something went wrong. Please try again later.";
}

// Close connection
sqlsrv_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">View Record</h1>
                    <div class="form-group">
                        <label>Name</label>
                        <p><b><?php echo $row["name"]; ?></b></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
