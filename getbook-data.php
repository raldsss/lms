<?php
require('dbconnection.php');

$sql = "SELECT book_category, COUNT(*) AS total_copies FROM book_tbl GROUP BY book_category";
$result = $connect->query($sql);

$data = [
    'categories' => [],
    'totals' => []
];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data['categories'][] = $row['book_category'];
        $data['totals'][] = $row['total_copies'];
    }
}

header('Content-Type: application/json');
echo json_encode($data);
?>
