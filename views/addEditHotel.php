<?php

require_once '../config.php';

if(!empty($_GET['id']))
{
    $sql = "SELECT * FROM hotel WHERE id = ".$_GET['id'];
    $result = sqlsrv_query($link, $sql);
    $hotel = sqlsrv_fetch_object( $result );
}

$actionLabel = !empty($_GET['id'])?'Edit':'Add';

?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<div class="row">
    <div class="col-md-12">
        <h2><?php echo $actionLabel; ?> hotel</h2>
    </div>
    <div class="col-md-6">
         <form method="post" action="../actions/hotelAction.php">
            <div class="form-group">
                <label>address</label>
                <input type="text" class="form-control" name="address" placeholder="Enter address" value="<?php echo !empty($hotel->address)?$hotel->address:''; ?>" required="">
            </div>
            <div class="form-group">
                <label>description</label>
                <input type="text" class="form-control" name="description" placeholder="Enter description" value="<?php echo !empty($hotel->description)?$hotel->description:''; ?>" required="">
            </div>
            <div class="form-group">
                <label>phone number</label>
                <input type="text" class="form-control" name="phone_number" placeholder="Enter phone number" value="<?php echo !empty($hotel->phone_number)?$hotel->phone_number:''; ?>">
            </div>
            <a href="index.php" class="btn btn-secondary">Back</a>
            <input type="hidden" name="id" value="<?php echo !empty($hotel->id)?$hotel->id:''; ?>">
            <input type="submit" name="submit" class="btn btn-success" value="Submit">
        </form>
    </div>
</div>