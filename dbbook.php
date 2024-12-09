<?php
require('dbconnection.php');

if (isset($_POST['add_book'])) {
    $admin_id = $_POST['admin_id'];
    $admin_name = $_POST['admin_name'];
    $isbn = $_POST['isbn'];
    $book_category = $_POST['book_category'];
    $book_title = $_POST['book_title'];
    $book_author = $_POST['book_author'];
    $publisher = $_POST['publisher'];
    $publication_year = $_POST['publication_year'] ?? null;
    $total_copies = $_POST['total_copies'];
    $copies_available = $_POST['total_copies'];
    $status = $_POST['status'];
    $date_added = date('Y-m-d H:i:s');

    $image = null;
    if (!empty($_FILES['image']['name'])) {
        $image_name = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $upload_dir = 'uploads/';
        
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $image_path = $upload_dir . basename($image_name);
        if (move_uploaded_file($image_tmp_name, $image_path)) {
            $image = $image_name;
        }
    }

    $check_stmt = $connect->prepare("SELECT COUNT(*) FROM book_tbl WHERE book_title = ? AND isbn = ?");
    $check_stmt->bind_param("ss", $book_title, $isbn);
    $check_stmt->execute();
    $check_stmt->bind_result($count);
    $check_stmt->fetch();
    $check_stmt->close();

    if ($count > 0) {
        echo "<script>
                alert('Book with the same title and ISBN already exists!');
                window.location.href = 'book_category.php';
              </script>";
    } else {
        $stmt = $connect->prepare("
            INSERT INTO book_tbl (admin_id, admin_name, isbn, book_category, book_title, book_author, publisher, publication_year, total_copies, copies_available, image, status, date_added)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("isssssssissss", $admin_id, $admin_name, $isbn, $book_category, $book_title, $book_author, $publisher, $publication_year, $total_copies, $copies_available, $image, $status, $date_added);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Book added successfully!');
                    window.location.href = 'book_category.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Failed to add book. Please try again.');
                    window.location.href = 'book_category.php';
                  </script>";
        }

        $stmt->close();
    }

    $connect->close();
}
?>
