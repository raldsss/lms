<?php
require('dbconnection.php');

$sql = "SELECT COUNT(*) AS unseen_count FROM borrow_tbl WHERE status = 'Pending'";
$result = $connect->query($sql);
$unseen_count = 0;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $unseen_count = $row['unseen_count'];
}

$connect->close();

echo json_encode(['unseen_count' => $unseen_count]);
?>
