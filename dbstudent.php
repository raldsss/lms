<?php
require('dbconnection.php');

if (isset($_POST['add_book'])) {
    $admin_id = $_POST['admin_id'];
    $admin_name = $_POST['admin_name'];
    $student_uid = $_POST['student_uid'];
    $student_name = $_POST['student_name'];
    $student_course = $_POST['student_course'];
    $student_year = $_POST['student_year'];
    $student_section = $_POST['student_section'];
    $student_password = $_POST['student_password'];
    // $student_password = password_hash($_POST['student_password'], PASSWORD_DEFAULT);

    $check_stmt = $connect->prepare("SELECT * FROM student_tbl WHERE student_uid = ?");
    $check_stmt->bind_param("s", $student_uid);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>
                alert('Student ID already exists!');
                window.history.back();
              </script>";
    } else {
        $stmt = $connect->prepare("
            INSERT INTO student_tbl (admin_id, admin_name, student_uid, student_name, student_course, student_year, student_section, student_password)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("isssssss", $admin_id, $admin_name, $student_uid, $student_name, $student_course, $student_year, $student_section, $student_password);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Student added successfully!');
                    window.location.href = 'manage_student.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Failed to add student. Please try again.');
                    window.history.back();
                  </script>";
        }

        $stmt->close();
    }

    $check_stmt->close();
    $connect->close();
} else {
    echo "<script>
            alert('Invalid request.');
            window.history.back();
          </script>";
}
?>
