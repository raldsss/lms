<?php
require('dbconnection.php');

$sql = "SELECT book_title, total_book FROM book_tbl";
$result = $conn->query($sql);

$data = [
    'titles' => [],
    'copies' => []
];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data['titles'][] = $row['book_title'];
        $data['copies'][] = $row['total_book'];
    }
}

header('Content-Type: application/json');
echo json_encode($data);
?>
