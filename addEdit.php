<?php
if(!empty($_GET['id']))
{
    require_once 'config.php';

    $sql = "SELECT * FROM room WHERE id = ".$_GET['id'];
    $result = sqlsrv_query($link, $sql);
    $obj = sqlsrv_fetch_object( $result );
}

$actionLabel = !empty($_GET['id'])?'Edit':'Add';

?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<div class="row">
    <div class="col-md-12">
        <h2><?php echo $actionLabel; ?> room</h2>
    </div>
    <div class="col-md-6">
         <form method="post" action="roomAction.php">
            <div class="form-group">
                <label>Number</label>
                <input type="text" class="form-control" name="number" placeholder="Enter number" value="<?php echo !empty($obj->number)?$obj->number:''; ?>" required="">
            </div>
            <div class="form-group">
                <label>Floor</label>
                <input type="text" class="form-control" name="floor" placeholder="Enter floor" value="<?php echo !empty($obj->floor)?$obj->floor:''; ?>" required="">
            </div>

            <a href="index.php" class="btn btn-secondary">Back</a>
            <input type="hidden" name="id" value="<?php echo !empty($obj->id)?$obj->id:''; ?>">
            <input type="submit" name="submit" class="btn btn-success" value="Submit">
        </form>
    </div>
</div>