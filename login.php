<?php

require("db.php");
if(isset($_POST['Submit']))
{
    
    $email =  $_POST['email'];
    $password = $_POST['password'];

    if(empty($email) || empty($password))
    {
        echo "<script>window.alert('fill in all fields')</script>";
        exit();
    }
    else
        {
            
            $results = mysqli_query($conn,"SELECT * FROM kokopshe WHERE email='$email'");

            if(mysqli_num_rows($results) > 0)
            {
                if($row = mysqli_fetch_assoc($results))
                {
                    $passwordChecker = password_verify($password, $row['password']);
                    if($passwordChecker == false)
                    {
                        echo "<script>window.alert('wrong password or username')</script>";
                        exit();
                    }
                    else
                    {
                        $str = uniqid('', true);
                        session_start();
                        $_SESSION['id'] = $row['id'];
                        $_SESSION['firstname'] = $row['firstname'];
                        $_SESSION['lastname'] = $row['lastname'];
                        $_SESSION['location'] = $row['location'];
                        $_SESSION['role'] = $row['role'];
                        if($row['role'] == 'Parent')
                        {
                            header("location: welcome.php");
                        }
                        else
                        {
                            header("location: index.php");
                        }
                        
                    }
                }
            }
            else
            {
                echo "<script>window.alert('wrong password or username')</script>";
                exit();
            }

        }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>kokopshe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="KOKOPSHE.ico" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <style>
    body{ font: 14px sans-serif; }
    .wrapper{ width: 250px; padding: 20px; }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="main.js"></script>
</head>
<body>
    <br>
    <img src="heart.svg" alt="KOKOPSHE" class="container" width="100px" height="200px" />
    
    <form class="container"  method="POST">
        <span><b>E-mail</b></span>
        <input type="email" name="email" class="form-control" placeholder="E-mail"><br>
       
        <span><b>Password</b></span>
        <input type="password" name="password" class="form-control" placeholder="Password"><br>
       
        <input type="submit" name="Submit" value="Login" class="btn btn-info"><br><br>
        <a href="signup.php" style="text-decoration:none">Don't have an account? <b style="color:skyblue;">SignUp</b></a>
        <hr>
    </form>
</body>
