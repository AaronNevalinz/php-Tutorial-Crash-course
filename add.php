<?php

    include('config/db_connect.php');

    $title = $email = $ingredients = '';
    
    $errors = ['email' => '', 'title'=>'', 'ingredients'=>''];

    if(isset($_POST['submit'])){


        // form checks
        if(empty($_POST['email'])){
            $errors['email'] = 'An email is required <br />';
        } else{
            $email = $_POST['email'];
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errors['email'] = 'Email must be a valid email address <br />';
            }
        }

        if(empty($_POST['title'])){
            $errors['title'] = 'A Title is required <br />';
        } else{
            $title = $_POST[ 'title' ];
            if(!preg_match('/^[a-zA-Z\s]+$/', $title)){
                $errors['title'] = 'Title must be letters and spaces only <br />';
            }
        }

        if(empty($_POST['ingredients'])){
            $errors['ingredients'] = 'Atleast one Ingredient is required <br />';
        } else{
            $ingredients = $_POST[ 'ingredients' ];
            if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)){
                $errors['ingredients'] = 'Ingredients must be a comma seperated list <br />';
            }
        }

        if(array_filter( $errors )){
            // echo 'no errors found';
        } else{
            // protecting sql injections
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);

            // create sql
            $sql = "INSERT INTO pizza(title, email, ingredients) VALUES('$title', '$email', '$ingredients')";

            // save to db and check
            if(mysqli_query($conn, $sql)){
                //success
                // redirect to the index.php page
                header('location: index.php');
            } else {
                //error
                echo 'query error' . mysql_error($conn);
            }

        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <?php include('templates/header.php');?>

    <section class="container grey-text">
        <h4 class="center">Add a pizza</h4>
        <form action="add.php" class="white" method='POST'>
            <label for="">Your Email</label>
            <input type="text" name='email' value='<?php echo $email; ?>'>
            <div class="red-text"><?php echo $errors['email']; ?></div>
            <label for="">Pizza Title: </label>
            <input type="text" name='title' value='<?php echo $title; ?>'>
            <div class="red-text"><?php echo $errors['title']; ?></div>
            <label for="">Ingredients (comma seperated): </label>
            <input type="text" name='ingredients' value='<?php echo $ingredients; ?>'>
            <div class="red-text"><?php echo $errors['ingredients']; ?></div>
            <div class="center">
                <input type="submit" value="submit" name='submit' class='z-depth-0 btn brand'>
            </div>
        </form>
    </section>

    <?php include('templates/footer.php');?>

</html>