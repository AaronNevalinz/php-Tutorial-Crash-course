<?php

// connect to database
$conn = mysqli_connect('localhost', 'nevalinz', '2425', 'ninja_pizza');

// check connection
if(!$conn){
    echo 'connection error: ' . mysqli_connect_error();
}

?>