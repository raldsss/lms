<?php
require('dbconnection.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $student_id = $_POST['student_id'];
    $student_name = $_POST['student_name'];
    $student_course = $_POST['student_course'];
    $student_year = $_POST['student_year'];
    $student_section = $_POST['student_section'];
    $student_uid = $_POST['student_uid'];
    $student_password = $_POST['student_password'];

    $sql = "UPDATE student_tbl SET 
            student_name = ?, 
            student_course = ?, 
            student_year = ?, 
            student_section = ?, 
            student_uid = ?";

    if (!empty($student_password)) {
        $sql .= ", student_password = ?";
    }

    $sql .= " WHERE student_id = ?";
    
    $stmt = $connect->prepare($sql);
    
    if (!empty($student_password)) {
        $stmt->bind_param("ssssssi", $student_name, $student_course, $student_year, $student_section, $student_uid, $student_password, $student_id);
    } else {
        $stmt->bind_param("sssssi", $student_name, $student_course, $student_year, $student_section, $student_uid, $student_id);
    }

    if ($stmt->execute()) {
        echo "<script>
                alert('Student updated successfully!');
                window.location.href = 'manage_student.php';
              </script>";
    } else {
        echo "<script>
                alert('Failed to update student.');
                window.location.href = 'manage_student.php';
              </script>";
    }

    $stmt->close();
    $connect->close();
}
?>
