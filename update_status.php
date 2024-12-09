<?php
    require('dbconnection.php');
    if (isset($_POST['borrow_id']) && isset($_POST['status'])) {
        $borrowId = $_POST['borrow_id'];
        $status = $_POST['status'];

        require('dbconnection.php');

        $updateQuery = "UPDATE borrow_tbl SET status = '$status' WHERE borrow_id = $borrowId";
        if ($connect->query($updateQuery) === TRUE) {
            echo "Status updated successfully.";
        } else {
            echo "Error updating status: " . $connect->error;
        }

        $connect->close();
    }
?>
