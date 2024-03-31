<?php

include('config/db_connect.php');

if(isset($_POST['delete'])){
    $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

    $sql = "DELETE FROM pizza WHERE id=$id_to_delete";

    if(mysqli_query($conn, $sql)){
        // success
        header('location: index.php');
    } else {
        // failure
        echo 'Query Error: '.mysqli_error($conn);
    }
}

// check GET request id param
if(isset($_GET['id'])){
     $id = mysqli_real_escape_string($conn, $_GET['id']);

    //  make sql
    $sql = "SELECT * from pizza WHERE id = $id";

    // get the query result
    $result = mysqli_query($conn, $sql);

    // fetch the result in array format
    $pizza = mysqli_fetch_assoc($result);

    // free up memoery
    mysqli_free_result($result);

    mysqli_close($conn);

    // print_r($pizza);
}

?>

<!DOCTYPE html>
<html lang="en">
    <?php include('templates/header.php');?>

    <div class="container center">
        <?php if($pizza):?>
            <h4> <?php echo htmlspecialchars($pizza['title']); ?></h4>
            <p>Created by: <?php echo htmlspecialchars($pizza['email']); ?></p>
            <p><?php echo date($pizza['created_at']); ?></p>
            <p>Ingredients: </p>
            <p><?php echo htmlspecialchars($pizza['ingredients']); ?></p>

            <!-- delete form -->
            <form action="details.php" method='POST'>
                <input type="hidden" name="id_to_delete" value='<?php echo $pizza['id']; ?>'>
                <input type="submit" name='delete' value='Delete' class='btn brand z-depth-0'>
            </form>

        <?php else: ?>
            <h5>No Such pizza exists</h5>
        <?php endif; ?>
    </div>

    
    <?php include('templates/footer.php');?>
</html>