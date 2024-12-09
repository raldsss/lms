<?php
require('dbconnection.php');
if (isset($_GET['id'])) {
    $student_id = intval($_GET['id']);
    $sql = "DELETE FROM student_tbl WHERE student_id = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("i", $student_id);
    if ($stmt->execute()) {
        echo "Student deleted successfully.";
    } else {
        echo "Error deleting student.";
    }
    $stmt->close();
}
$connect->close();
header("Location: manage_student.php");
exit();
?>
