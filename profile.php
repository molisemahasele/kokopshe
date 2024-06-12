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




if(isset($_POST['submit']))
  { 
    $email = $_POST['email'];
   
    $res = $_POST['res'];
    if($row['role'] == "Driver")
    {
        $route = $_POST['route'];
        $xp = $_POST['xp'];
        $capacity = $_POST['capacity'];   
    }
    else
    {
        $route = NULL;
        $xp = NULL;
        $capacity = NULL;
    }

    if($row['role'] == "Parent")
    {
        $children = $_POST['children'];
    }
    else
    {
        $children = NULL;
    }

    if($row['role'] == "School Admin")
    {
        $drivers = $_POST['drivers'];
    }
    else
    {
        $drivers = NULL;
    }

    
    $school = $_POST['school'];




    $file = $_FILES['file'];

	  $filename = $_FILES['file']['name'];
  	$fileTmp = $_FILES['file']['tmp_name'];
	  $fileType = $_FILES['file']['type'];
	  $fileSize = $_FILES['file']['size'];
	  $fileErr = $_FILES['file']['error'];

	  $fileExt = explode('.', $filename);
	  $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png', 'pdf', 'mp4');
    
    if(in_array($fileActualExt, $allowed))
	  {
		  if($fileErr === 0)
		  {
			  if($fileSize < 10000000000)
			  {
				  $filenameNew  = "profile".$id.".".$fileActualExt;
				  $fileDestination = 'uploads/'.$filenameNew;
				  move_uploaded_file($fileTmp, $fileDestination);
				  $sql = "UPDATE kokopshe SET status=1 WHERE id='$id';";
				  $result = mysqli_query($conn, $sql);
			  }
			  else
			  {
				  echo "File too big";
			  }
		  }
		  else
		  {
			  echo "there was an error";
		  }
	  }
	  

   
    $select = mysqli_query($conn, "SELECT * FROM kokopshe WHERE id='$id'");
    $row = mysqli_fetch_assoc($select);


    

    if(empty($email))
    {
      $email = $row['email'];
    }
    if(empty($children))
    {
      $children = $row['Children'];
    }
    if(empty($school))
    {
      $school = $row['School'];
    }
    if(empty($drivers))
    {
      $drivers = $row['Drivers'];
    }
    if(empty($xp))
    {
      $xp = $row['Experience'];
    }
    if(empty($route))
    {
      $route = $row['Route'];
    }
    if(empty($capacity))
    {
      $xp = $row['capacity'];
    }
    if(empty($res))
    {
      $res= $row['Residence'];
    }



    $filename = $_FILES['img']['name'];
    $tmpname = $_FILES['img']['tmp_name'];
    $filetype = $_FILES['img']['type'];
    
    // Increase memory limit for the script
    ini_set('memory_limit', '256M');
    
    for ($i = 0; $i < count($tmpname); $i++) {
        // Check if it's a valid image
        if (getimagesize($tmpname[$i])) {
            // Load the image
            $image = imagecreatefromstring(file_get_contents($tmpname[$i]));
    
            // Define maximum dimensions for the compressed image
            $maxWidth = 800;
            $maxHeight = 600;
    
            // Get the original image dimensions
            $originalWidth = imagesx($image);
            $originalHeight = imagesy($image);
    
            // Calculate new dimensions while maintaining the aspect ratio
            $newWidth = $originalWidth;
            $newHeight = $originalHeight;
    
            if ($originalWidth > $maxWidth || $originalHeight > $maxHeight) {
                $ratio = $originalWidth / $originalHeight;
    
                if ($newWidth > $maxWidth) {
                    $newWidth = $maxWidth;
                    $newHeight = $newWidth / $ratio;
                }
    
                if ($newHeight > $maxHeight) {
                    $newHeight = $maxHeight;
                    $newWidth = $newHeight * $ratio;
                }
            }
    
            // Create a new image with the calculated dimensions
            $compressedImage = imagecreatetruecolor($newWidth, $newHeight);
    
            // Preserve transparency if necessary
            $extension = strtolower(pathinfo($filename[$i], PATHINFO_EXTENSION));
            if ($extension == 'png' || $extension == 'gif') {
                imagealphablending($compressedImage, false);
                imagesavealpha($compressedImage, true);
                $transparent = imagecolorallocatealpha($compressedImage, 255, 255, 255, 127);
                imagefilledrectangle($compressedImage, 0, 0, $newWidth, $newHeight, $transparent);
            }
    
            // Copy and resize the original image to the new image
            imagecopyresampled($compressedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);
    
            // Save the compressed image to a temporary file
            $tmp = tempnam(sys_get_temp_dir(), 'img');
            if ($extension == 'png') {
                imagepng($compressedImage, $tmp);
            } elseif ($extension == 'gif') {
                imagegif($compressedImage, $tmp);
            } else {
                imagejpeg($compressedImage, $tmp, 80); // Adjust the quality (80) as needed
            }
    
            // Read the temporary compressed image and insert it into the database
            $compressedImageContent = addslashes(file_get_contents($tmp));
    
            // Insert the data into the database
            $query = mysqli_query($conn, "INSERT INTO images(driverId, image) VALUES ('$id', '$compressedImageContent')");
    
            // Clean up temporary files
            unlink($tmp);
    
            // Free up memory
            imagedestroy($image);
            imagedestroy($compressedImage);
        }
    }

    $update = mysqli_query($conn, "UPDATE kokopshe SET email='$email', Children='$children', School='$school', Drivers='$drivers', Experience='$xp', Route='$route', capacity='$capacity', Residence='$res' WHERE id='$id'");
    echo '<script>alert("success!")</script>';
  }



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
<body class="bg-gray-300">
    


    <div class="w-full h-64 bg-cover bg-center relative" style="background:skyblue;">
        <div class="container mx-auto flex items-center relative h-full">
            <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-white">
            <?php 
                    if($row['status'] == 0)
                    {
                        echo '<img src="https://st3.depositphotos.com/6672868/13701/v/450/depositphotos_137014128-stock-illustration-user-profile-icon.jpg" alt="Profile Picture" class="object-cover w-full h-full">';
                    }
                    else
                    {
                        echo '<img width="10px" src="Uploads/profile'.$row['id'].'.jpg" alt="uploads/profile'.$row['id'].'.jpg"
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
            <button type="button" class="ml-2 btn btn-info" data-bs-toggle="modal" data-bs-target="#myModal">
                Edit Profile
            </button>
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



<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel4" aria-hidden="true">
        <div class="modal-dialog d-flex justify-content-center">
            <div class="modal-content w-75">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Edit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form method="Post" enctype="multipart/form-data">
                        <!-- Name input -->
                        
                        <div class="form-outline mb-4">
                          <input class="form-control" type='file' placeholder='upload img' name='file'>
                          <label class="form-label" for="email4">Profile Picture</label>
                        </div>


                         <?php if($row['role'] == 'Driver')
                        {?>
                        <div class="form-outline mb-4">
                          <input type="file" name="img[]" multiple="multiple" class="form-control">
                          <label class="form-label" for="email4">Select Image Files to Upload</label>
                        </div>
                        <?php } ?>
       
    
                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <input name="email" type="email" id="email4" placeholder="name@example.com" class="form-control" />
                            <label class="form-label" for="email4">Email address</label>
                        </div>
  
  
                      <div class="form-outline mb-4">
                        <input name="capacity" type="text" id="name4" placeholder="Capacity" class="form-control" />
                        <label class="form-label" for="name4">Capacity</label>
                    </div>
  
                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <input name="school" type="text" id="email4" placeholder="School" class="form-control" />
                        <label class="form-label" for="email4">School</label>
                    </div>
                    <?php if($row['role'] == 'Driver')
                    {?>
                    <div class="form-outline mb-4">
                      <input name="route" type="text" placeholder="phone" id="name4" class="form-control" />
                      <label class="form-label" for="name4">Route</label>
                  </div>
                    <?php } ?>
  
                  <div class="form-outline mb-4">
                    <input name="res" type="text" placeholder="Residence" id="name4" class="form-control" />
                    <label class="form-label" for="name4">Residence</label>
                  </div>

                <?php if($row['role'] == "School Admin"){ ?>
                <div class="form-outline mb-4">
                    <input name="drivers" type="text" placeholder="Drivers" id="name4" class="form-control" />
                    <label class="form-label" for="name4">Drivers</label>
                </div>
                <?php } ?>

                <?php if($row['role'] == "Parent"){ ?>
                <div class="form-outline mb-4">
                    <input name="children" type="text" placeholder="Children" id="name4" class="form-control" />
                    <label class="form-label" for="name4">Children</label>
                </div>
                <?php } ?>

                <?php if($row['role'] == "Driver"){ ?>
                <div class="form-outline mb-4">
                    <input name="xp" type="number" placeholder="Experience" id="name4" class="form-control" />
                    <label class="form-label" for="name4">Experience</label>
                </div>
                <?php } ?>
                        
                        <!-- Submit button -->
                        <input name="submit" value="Send" type="submit" class="btn btn-primary btn-block">
                    </form>
                </div>
            </div>
        </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>


    

</body>
</html>

