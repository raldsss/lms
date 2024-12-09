<?php
require('dbconnection.php');

$sql = "SELECT book_title, SUM(borrow_quantity) as total_borrowed FROM borrow_tbl WHERE status = 'Borrowed' GROUP BY book_title ORDER BY total_borrowed DESC";
$result = $connect->query($sql);

$bookData = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bookData[] = $row;
    }
}

echo json_encode($bookData);
?>
