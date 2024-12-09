<?php
    session_start();
    include('dbconnection.php');

    if (!isset($_SESSION['student_name'])) {
        header('Location: index.php'); 
        exit();
    }
    $student_id = $_SESSION['student_id'];
    $query = mysqli_query($connect, "SELECT * FROM `student_tbl` WHERE student_id='$student_id'");
    $row = mysqli_fetch_assoc($query);

    if ($row) {
        $student_id = $row['student_id'];
        $student_name = ucwords($row['student_name']);
        $student_uid = ucwords($row['student_uid']);
        $student_course = ucwords($row['student_course']);
        $student_year = ucwords($row['student_year']);
        $student_section = ucwords($row['student_section']);
        $student_password = $row['student_password'];

    } else {
        $student_id = "";
        $student_name = "";
        $student_uid = "";
        $student_password = "";
    }
?> 