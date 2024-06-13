<?php

require("db.php");
session_start();
if(!isset($_SESSION['id']))
{
    header("location: login.php");
}

$id = $_GET['id'];
$get = mysqli_query($conn, "SELECT * FROM kokopshe WHERE id='$id'");
$row = mysqli_fetch_assoc($get);

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>kokopshe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <link rel="icon" href="KOKOPSHE.ico" type="image/x-icon" />
    <script src="main.js"></script>
    <script src="https://kit.fontawesome.com/6a2d1d7f10.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
<body class="bg-gray-300">
    


    <div class="w-full h-64 bg-cover bg-center relative" style="background-image: url('bg.png')">
        <div class="container mx-auto flex items-center relative h-full">
            <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-white">
            <?php 
                    if($row['status'] == 0)
                    {
                        echo '<img src="https://st3.depositphotos.com/6672868/13701/v/450/depositphotos_137014128-stock-illustration-user-profile-icon.jpg" alt="Profile Picture" class="object-cover w-full h-full">';
                    }
                    else
                    {
                        echo '<img width="10px" src="Uploads/profile'.$row['id'].'.jpg" alt="Uploads/profile'.$row['id'].'.jpg"
                            class="object-cover w-full h-full">';
                    }
                ?>
            </div>
            <div class="ml-4 font-semibold">Welcome <?php echo $row['firstname']; ?></div>
        </div>
        
    </div>
    <br>
    <div class="container">
        <div class="h-64 rounded-lg bg-white">
            <h1 class="ml-2 font-bold text-2xl">Profile Details</h1>
            <?php
            echo "<div class='ml-2 font-semibold'>Name: ".$row['firstname']." ".$row['lastname']."</div>";
            echo "<div class='ml-2 font-semibold'>Email: ".$row['email']."</div>";
            
            if($row['role'] == "Driver")
            {
                echo "<div class='ml-2 font-semibold'>Capacity: ".$row['capacity']."</div>";
                echo "<div class='ml-2 font-semibold'>Experience: ".$row['Experience']."</div>";
                echo "<div class='ml-2 font-semibold'>Route: ".$row['Route']."</div>";
                echo "<div class='ml-2 font-semibold'>Residence: ".$row['Residence']."</div>";
            }
            if($row['role'] == "Parent")
            {
                echo "<div class='ml-2 font-semibold'>Residence: ".$row['Residence']."</div>";
                echo "<div class='ml-2 font-semibold'>Children: ".$row['Children']."</div>";
            }
            if($row['role'] == "School Admin")
            {
                echo "<div class='ml-2 font-semibold'>Drivers: ".$row['Drivers']."</div>";
            }
            echo "<div class='ml-2 font-semibold'>School: ".$row['School']."</div>";
           
            
            ?>
            
        </div>
    </div><br>

    <?php
   if($row['role'] == "Driver")
   {
    $image = mysqli_query($conn, "SELECT * FROM images WHERE driverId='$id'");
    while($rowImages = mysqli_fetch_assoc($image))
        {
            echo '
    		<div class=" container col-12 col-md-6 col-lg-4">
    			<div class="card">
                <img class="related-prod-img" style="height:170px;" height="100px" src="data:image/jpeg;base64,'.base64_encode( $rowImages['image'] ).'"/">
    			</div>
    		</div><br>';
        }
   }
    ?>