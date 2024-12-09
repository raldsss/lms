<?php
require('dbconnection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isbn = $_POST['isbn'];
    $book_title = $_POST['book_title'];
    $book_author = $_POST['book_author'];
    $book_category = $_POST['book_category'];
    $publisher = $_POST['publisher'];
    $publication_year = $_POST['publication_year'];
    $copies_available = $_POST['copies_available'];
    $total_copies = $_POST['total_copies'];
    $book_id = $_POST['book_id'];

    $stmt = $connect->prepare("
        UPDATE book_tbl
        SET isbn = ?, book_title = ?, book_author = ?, book_category = ?, publisher = ?, publication_year = ?, copies_available, total_copies = ?
        WHERE book_id = ?
    ");
    $stmt->bind_param("ssssssssi", $isbn, $book_title, $book_author, $book_category, $publisher, $publication_year,  $copies_available, $total_copies, $book_id);

    if ($stmt->execute()) {
        echo "<script>
                alert('Book updated successfully!');
                window.location.href = 'book_category.php';
              </script>";
    } else {
        echo "<script>
                alert('Failed to update book. Please try again.');
                window.location.href = 'book_category.php';
              </script>";
    }

    $stmt->close();
    $connect->close();
}
?>
