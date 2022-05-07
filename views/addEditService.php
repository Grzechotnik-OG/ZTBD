<?php

require_once '../config.php';

if(!empty($_GET['id']))
{
    $sql = "SELECT * FROM service WHERE id = ".$_GET['id'];
    $result = sqlsrv_query($link, $sql);
    $service = sqlsrv_fetch_object( $result );
}

$actionLabel = !empty($_GET['id'])?'Edit':'Add';

?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<div class="row">
    <div class="col-md-12">
        <h2><?php echo $actionLabel; ?> service</h2>
    </div>
    <div class="col-md-6">
         <form method="post" action="../actions/serviceAction.php">
            <div class="form-group">
                <label>name</label>
                <input type="text" class="form-control" name="name" placeholder="Enter name" value="<?php echo !empty($service->name)?$service->name:''; ?>" required="">
            </div>
            <div class="form-group">
                <label>description</label>
                <input type="text" class="form-control" name="description" placeholder="Enter description" value="<?php echo !empty($service->description)?$service->description:''; ?>" required="">
            </div>
            <a href="index.php" class="btn btn-secondary">Back</a>
            <input type="hidden" name="id" value="<?php echo !empty($service->id)?$service->id:''; ?>">
            <input type="submit" name="submit" class="btn btn-success" value="Submit">
        </form>
    </div>
</div>