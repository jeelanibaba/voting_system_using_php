<?php 
    session_start();
    require_once("config.php");

    if($_SESSION['key'] != "AdminKey")
    {
        echo "<script> location.assign('logout.php'); </script>";
        die;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adminpanel - Online Voting System</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    
<div class="container-fluid">
    <div class="row bg-black text-white align-items-center"> <!-- Added align-items-center for vertical alignment -->
        <div class="col-lg-1 col-md-2 col-sm-3 col-3"> <!-- Adjusted column sizes for different screen sizes -->
            <div style="width: 80px; height: 80px; background-color: #fff; border-radius: 50%; display: flex; justify-content: center; align-items: center; overflow: hidden;">
                <img src="../assets/images/logo1.gif" style="width: 100%; height: 100%; object-fit: cover;" alt="Logo in Circular Container" class="img-fluid"/>
            </div>
        </div>
        <div class="col-lg-11 col-md-10 col-sm-9 col-9"> <!-- Adjusted column sizes for different screen sizes -->
            <h3>ONLINE VOTING SYSTEM</h3>
            <h4><small style="font-weight: bold; font-size: 18px;">Welcome <?php echo $_SESSION['username']; ?></small></h4>
        </div>
    </div>
</div>
