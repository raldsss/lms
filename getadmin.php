<?php
    session_start();
    include('dbconnection.php');

    if (!isset($_SESSION['admin_name'])) {
        header('Location: index.php'); 
        exit();
    }
    $admin_id = $_SESSION['admin_id'];
    $query = mysqli_query($connect, "SELECT * FROM `admin_tbl` WHERE admin_id='$admin_id'");
    $row = mysqli_fetch_assoc($query);

    if ($row) {
        $admin_id = $row['admin_id'];
        $admin_name = ucwords($row['admin_name']);
        $email = $row['email'];
        $mobile_number = ucwords($row['mobile_number']);
        $username = ucwords($row['username']);
        $password = $row['password'];

    } else {
        $admin_id = "";
        $admin_name = "";
        $username = "";
        $password = "";
    }
?> 