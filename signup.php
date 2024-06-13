<?php
require("db.php");
if(isset($_POST['Submit']))
{
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $role = $_POST['Role'];
    $location = $_POST['location'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if(empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($confirm))
    {
        echo "<script>alert('Fill in all fields')</script>";
        exit();
    }
    else
    {
        if($confirm != $password)
        {
            echo "<script>alert('Passwords dont match!')</script>";
            exit();
        }
        else
        {
            $password_hash = PASSWORD_HASH($password, PASSWORD_DEFAULT);
            $insert = mysqli_query($conn, "INSERT INTO kokopshe(firstname, lastname, email, role, location, password) VALUES('$firstname', '$lastname', '$email', '$role', '$location', '$password_hash')");
            if($insert)
            {
                echo "<script>alert('Successfully Registered')</script>";
                
            }
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body>
    
    <img src="KOKOPSHE2.png" alt="KOKOPSHE"  class="w-full h-96 bg-cover bg-center relative" />
    
    <form class="container"  method="POST">
        <span><b>Firstname</b></span>
        <input type="text" name="firstname" class="form-control" placeholder="Firstname"><br>
        <span><b>Lastname</b></span>
        <input type="text" name="lastname" class="form-control" placeholder="Lastname"><br>
        <span><b>E-mail</b></span>
        <input type="email" name="email" class="form-control" placeholder="E-mail"><br>
        <span><b>Location</b></span>
        <select name="location" class="form-control">
            <option>--Choose Location--</option>
            <option>Ha-Seoli</option>
            <option>Leqele</option>
            <option>Lithabaneng</option>
            <option>Qoaling</option>
            <option>Thetsane</option>
        </select><br>
        <span><b>Role</b></span>
        <select name="Role" class="form-control">
            <option>--Choose Role--</option>
            <option>Driver</option>
            <option>Parent</option>
            <option>School Admin</option>
        </select><br>
        <span><b>Password</b></span>
        <input type="password" name="password" class="form-control" placeholder="Password"><br>
        <span><b>Confirm Password</b></span>
        <input type="password" name="confirm" class="form-control" placeholder="Confirm Password"><br>
        <input type="submit" name="Submit" value="Register" class="btn btn-info"><br><br>
        <a href="login.php" style="text-decoration:none">Already have an account? <b style="color:skyblue;">Login</b></a>
        <hr>
    </form>
</body>
</html>