<?php

require("db.php");
session_start();
if(!isset($_SESSION['id']))
{
    header("location: login.php");
}

$id = $_SESSION['id'];
$get = mysqli_query($conn, "SELECT * FROM kokopshe WHERE id='$id'");
$row = mysqli_fetch_assoc($get);
$location = $row['location'];

$driver = "Driver";




?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
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
<body>
    <img src="KOKOPSHE.png" alt="KOKOPSHE" class="container" width="100px" height="200px" />
    <div class="container">
        <div class="bg-gray-400 ml-2 mr-2 h-auto rounded-lg p-4">

            <div class="flex justify-center items-center space-x-4">
                <h1 class="text-2xl font-bold">Drivers In Your Location</h1> 
            </div><br>

            
            <?php
                // Database connection and query (adjust the $conn and $query according to your actual database setup)
                $query = "SELECT * FROM kokopshe WHERE role='driver' and location='$location'";
                $get_drivers = mysqli_query($conn, $query);
                
                // Initialize a counter
                $counter = 0;
                
                while($rowDrivers = mysqli_fetch_assoc($get_drivers)) 
                {
                    // Increment the counter
                    $counter++;
                
                    // Check if the driver status is 0 or 1
                    if($rowDrivers['status'] == 0) {
                        $profileImage = "https://st3.depositphotos.com/6672868/13701/v/450/depositphotos_137014128-stock-illustration-user-profile-icon.jpg";
                    } 
                    else 
                    {
                        $profileImage = "Uploads/profile".$rowDrivers['id'].".jpg";
                    }
                
                    // Display the first 4 drivers
                    if ($counter <= 4) 
                    {
                        echo '<div class="flex items-center bg-white space-x-2 p-2 rounded-lg overflow-hidden border-4 border-white">
                                <img src="'.$profileImage.'" alt="Profile Picture" class="object-cover w-10 h-10 rounded-full">
                                <a href="visit.php?id='.$rowDrivers['id'].'" class="text-sm">'.$rowDrivers['firstname'].' '.$rowDrivers['lastname'].'</a>
                              </div><br>';
                    } 
                    // Collect the rest of the drivers for later display
                    else 
                    {
                        // Wrap the rest of the drivers in the <details> element
                        echo '<details class="bg-white rounded-lg shadow p-4 mb-4">
                                <summary class="cursor-pointer font-semibold text-blue-600">
                                    Show More
                                </summary>
                                <div class="mt-4 flex flex-col space-y-4">';
                
                        // Loop through the rest of the drivers
                        do 
                        {
                            echo '<div class="flex items-center bg-white space-x-2 p-2 rounded-lg overflow-hidden border-4 border-white">
                                    <img src="'.$profileImage.'" alt="Profile Picture" class="object-cover w-10 h-10 rounded-full">
                                    <a href="visit.php?id='.$rowDrivers['id'].'" class="text-sm">'.$rowDrivers['firstname'].' '.$rowDrivers['lastname'].'</a>
                                  </div><br>';
                        } while ($rowDrivers = mysqli_fetch_assoc($get_drivers));
                
                        echo '   </div>
                              </details>';
                        break; // Exit the loop since all drivers have been processed
                    }
                }
            ?>

        </div>
    </div>

</body>
</html>