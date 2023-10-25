<?php

$user = 0;
$success =0;

if($_SERVER['REQUEST_METHOD']=='POST')
{
    include 'connect.php';
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    echo $hashedPassword;

    // sql code to query if the username exists in the database
    $sql = "select * from `registration` where username='$username'";

    // sends the query to the MYSQl and returns the results of this query 
    $result = mysqli_query($con, $sql);

    // if the results returns true, that is, the username is in our database
    if($result)
    {
        // check how many of that usernames is in our database
        $num = mysqli_num_rows($result);
        if($num > 0)
        {
            // echo "user already exists";
            $user = 1;
        }
        else
        {
            $sql = "insert into `registration` (username, password) values('$username','$hashedPassword')";

            $result = mysqli_query($con, $sql);
            
            if($result)
            {
                // echo "Sign Up successfully";
                $success = 1;
                header('location:login.php');
            }
            else
            {
                 die(mysqli_error($con));
            }
        } 
    }
}

?>






<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body>

    <?php
        if($user)
        {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Oh no sorry </strong> User already exists!.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    ?>

    <?php
        if($success)
        {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sucess </strong> You have successfully signed up.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    ?>



    <h1 class="text-center"> SIGN UP </h1>
        <div class="container mt-5">
        <form action="sign.php" method="post">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Name</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter username" name="username">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Enter password" name="password">
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                    </form>
        </div>
    
  </body>
</html>