<?php

require_once '../config.php';

if(!empty($_GET['id']))
{
    $sql = "SELECT * FROM client WHERE id = ".$_GET['id'];
    $result = sqlsrv_query($link, $sql);
    $client = sqlsrv_fetch_object( $result );
}

$actionLabel = !empty($_GET['id'])?'Edit':'Add';

?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<div class="row">
    <div class="col-md-12">
        <h2><?php echo $actionLabel; ?> client</h2>
    </div>
    <div class="col-md-6">
         <form method="post" action="../actions/clientAction.php">
            <div class="form-group">
                <label>address</label>
                <input type="text" class="form-control" name="address" placeholder="Enter address" value="<?php echo !empty($client->address)?$client->address:''; ?>" required="">
            </div>
            <div class="form-group">
                <label>name</label>
                <input type="text" class="form-control" name="name" placeholder="Enter name" value="<?php echo !empty($client->name)?$client->name:''; ?>" required="">
            </div>
            <div class="form-group">
                <label>surname</label>
                <input type="text" class="form-control" name="surname" placeholder="Enter surname" value="<?php echo !empty($client->surname)?$client->surname:''; ?>" required="">
            </div>
            <div class="form-group">
                <label>email</label>
                <input type="text" class="form-control" name="email" placeholder="Enter email" value="<?php echo !empty($client->email)?$client->email:''; ?>" required="">
            </div>
            <div class="form-group">
                <label>phone number</label>
                <input type="text" class="form-control" name="phone_number" placeholder="Enter phone number" value="<?php echo !empty($client->phone_number)?$client->phone_number:''; ?>">
            </div>
            <a href="index.php" class="btn btn-secondary">Back</a>
            <input type="hidden" name="id" value="<?php echo !empty($client->id)?$client->id:''; ?>">
            <input type="submit" name="submit" class="btn btn-success" value="Submit">
        </form>
    </div>
</div>