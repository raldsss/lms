<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit();
}

include('dbconnection.php');


$limit = 10;  
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;


$search = '';
if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($connect, $_POST['search']);
}


$search_query = $search ? "WHERE book_name LIKE '%$search%' OR category LIKE '%$search%'" : '';
$query = "SELECT * FROM book $search_query LIMIT $limit OFFSET $offset";
$books_result = mysqli_query($connect, $query);


$total_books_result = mysqli_query($connect, "SELECT COUNT(*) AS total FROM book $search_query");
$total_books = mysqli_fetch_assoc($total_books_result)['total'];
$total_pages = ceil($total_books / $limit);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_book'])) {
    $book_name = mysqli_real_escape_string($connect, $_POST['book_name']);
    $category = mysqli_real_escape_string($connect, $_POST['category']);
    $date = mysqli_real_escape_string($connect, $_POST['date']);

    if (empty($date)) {
        $date = date('Y-m-d');
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image'];
        $image_tmp_name = $image['tmp_name'];
        $image_name = $image['name'];

        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $image_type = mime_content_type($image_tmp_name);

        if (in_array($image_type, $allowed_types)) {
            $upload_dir = 'uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $new_image_name = uniqid('', true) . '-' . basename($image_name);
            $upload_path = $upload_dir . $new_image_name;

            if (move_uploaded_file($image_tmp_name, $upload_path)) {
                $query = "INSERT INTO book (book_name, category, image, date) VALUES ('$book_name', '$category', '$upload_path', '$date')";
                if (mysqli_query($connect, $query)) {
                    header('Location: books.php');
                    exit();
                } else {
                    $message = "Error adding book: " . mysqli_error($connect);
                }
            } else {
                $message = "Error uploading image.";
            }
        } else {
            $message = "Invalid image format. Only JPG, PNG, and GIF are allowed.";
        }
    } else {
        $message = "No image uploaded or there was an error with the image.";
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_book'])) {
    $book_id = mysqli_real_escape_string($connect, $_POST['book_id']);
    $book_name = mysqli_real_escape_string($connect, $_POST['book_name']);
    $category = mysqli_real_escape_string($connect, $_POST['category']);
    $date = mysqli_real_escape_string($connect, $_POST['date']);
    $image_path = $_POST['image_path'];  

    if (empty($date)) {
        $date = date('Y-m-d');
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        
        $image = $_FILES['image'];
        $image_tmp_name = $image['tmp_name'];
        $image_name = $image['name'];

        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $image_type = mime_content_type($image_tmp_name);

        if (in_array($image_type, $allowed_types)) {
            $upload_dir = 'uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $new_image_name = uniqid('', true) . '-' . basename($image_name);
            $upload_path = $upload_dir . $new_image_name;

            if (move_uploaded_file($image_tmp_name, $upload_path)) {
            
                $query = "UPDATE book SET book_name='$book_name', category='$category', image='$upload_path', date='$date' WHERE book_id='$book_id'";
                if (mysqli_query($connect, $query)) {
                    header('Location: books.php');
                    exit();
                } else {
                    $message = "Error updating book: " . mysqli_error($connect);
                }
            } else {
                $message = "Error uploading image.";
            }
        } else {
            $message = "Invalid image format. Only JPG, PNG, and GIF are allowed.";
        }
    } else {
        
        $query = "UPDATE book SET book_name='$book_name', category='$category', date='$date' WHERE book_id='$book_id'";
        if (mysqli_query($connect, $query)) {
            header('Location: books.php');
            exit();
        } else {
            $message = "Error updating book: " . mysqli_error($connect);
        }
    }
}


if (isset($_POST['delete_book_id'])) {
    $book_id = $_POST['delete_book_id'];
    $delete_query = "DELETE FROM book WHERE book_id = '$book_id'";

    if (mysqli_query($connect, $delete_query)) {
        header('Location: books.php');
        exit();
    } else {
        $message = "Error deleting book: " . mysqli_error($connect);
    }
}

$books_result = mysqli_query($connect, "SELECT * FROM book");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f6fa;
        }
        .dashboard {
            display: flex;
            width: 100%;
            height: 100vh;
        }
        .sidebar {
            background-color: #333;
            color: white;
            width: 250px;
            display: flex;
            flex-direction: column;
        }
        .sidebar-header {
  display: flex;
  align-items: center;
  padding: 20px;
  border-bottom: 1px solid #444;
}

.sidebar-header img {
  width: 50px; 
  height: auto;
  margin-right: 10px;
  border-radius: 45%;
}

.sidebar-header h4 {
  font-size: 1.5rem;
  margin: 0;
}

        .sidebar-menu {
            list-style: none;
            padding: 0;
        }
        .sidebar-menu li {
            padding: 15px 20px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .sidebar-menu li:hover {
            background-color: #444;
        }
        .sidebar-menu li i {
            margin-right: 10px;
        }
        .main-content {
            flex-grow: 1;
            padding: 20px;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        header h1 {
            font-weight: 600;
        }
        .profile-menu {
            display: flex;
            align-items: center;
        }
        .profile-menu img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .add-book-btn {
            margin-bottom: 20px;
            padding: 10px 20px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .add-book-btn:hover {
            background-color: #444;
        }
        .table {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .table h2 {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }
        table th, table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #f5f6fa;
            font-weight: 600;
        }
        .image {
            border-radius: 50%;
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .pagination a {
            color: #333;
            padding: 8px 16px;
            margin: 0 4px;
            text-decoration: none;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .pagination a:hover {
            background-color: #333;
            color: white;
        }
    </style>
</head>
<body>
<div class="dashboard">
<div class="sidebar">
  <div class="sidebar-header">
  <img src="https://www.pngitem.com/pimgs/m/665-6657133_library-management-system-logo-png-transparent-png.png" alt="LMS Logo">
    <h4>LMS</h4>
        </div>
        <ul class="sidebar-menu">
            <li><i class="fa-solid fa-home"></i><a href="dashboard.php" style="text-decoration:none;color:white;">Dashboard</a></li>
            <li><i class="fa-solid fa-book-open"></i> Books</li>
            <li><i class="fa-solid fa-user"></i> Members</li>
            <li><i class="fa-solid fa-list"></i> Borrowed Books</li>
            <li><i class="fa-solid fa-right-from-bracket"></i><a href="logout.php" style="text-decoration:none;color:white;">Logout</a></li>
        </ul>
    </div>
    <div class="main-content">
        <header>
            <h1>Books</h1>
            <div class="profile-menu">
                <img src="https://cdn4.iconfinder.com/data/icons/avatars-xmas-giveaway/128/batman_hero_avatar_comics-512.png" alt="User Profile">
                <span>Admin</span>
            </div>
        </header>
        <!-- Search form -->

        <section class="table">
        <form method="POST" action="" class="mb-3">
                <input type="text" name="search" class="form-control" placeholder="Search books by name or category" value="<?php echo $search; ?>">
            </form>
            <button class="add-book-btn" data-bs-toggle="modal" data-bs-target="#addBookModal">Add Book</button>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Book Name</th>
                        <th>Categories</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if (mysqli_num_rows($books_result) > 0) {
                        while ($book = mysqli_fetch_assoc($books_result)) {
                            ?>
                    <tr>
                        <td><?php echo $book['book_id']; ?></td>
                        <td><?php echo $book['book_name']; ?></td>
                        <td><?php echo $book['category']; ?></td>
                        <td><img class="image" src="<?php echo $book['image']; ?>" alt="Book Image" width="50" height="50"></td>
                        <td>
                            <!-- Add Edit button that triggers the edit modal -->
                            <a href="#" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editBookModal"
       data-id="<?php echo $book['book_id']; ?>"
       data-name="<?php echo $book['book_name']; ?>"
       data-category="<?php echo $book['category']; ?>"
       data-image="<?php echo $book['image']; ?>"
       data-date="<?php echo $book['date']; ?>"
       title="Edit"><i class="fa-solid fa-pen"></i></a>
       <form method="POST" action="" style="display:inline;">
                                <input type="hidden" name="delete_book_id" value="<?php echo $book['book_id']; ?>">
                                <button type="submit" class="btn btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this book?');">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="5">No records found for the search term "<?php echo $search; ?>".</td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
             <!-- Pagination links -->
             <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>" tabindex="-1">Previous</a>
                    </li>
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php echo $page == $total_pages ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
                    </li>
                </ul>
            </nav>
        </section>
    </div>
</div>

<div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBookModalLabel">Add a New Book</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="books.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="bookName" class="form-label">Book Name</label>
                        <input type="text" class="form-control" id="bookName" name="book_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <input type="text" class="form-control" id="category" name="category" required>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date">
                    </div>
                    <button type="submit" class="btn btn-primary" name="add_book">Add Book</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Edit Book Modal -->
<div class="modal fade" id="editBookModal" tabindex="-1" aria-labelledby="editBookModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBookModalLabel">Edit Book</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="books.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="editBookId" name="book_id">
                    <div class="mb-3">
                        <label for="editBookName" class="form-label">Book Name</label>
                        <input type="text" class="form-control" id="editBookName" name="book_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editCategory" class="form-label">Category</label>
                        <input type="text" class="form-control" id="editCategory" name="category" required>
                    </div>
                    <div class="mb-3">
                        <label for="editImage" class="form-label">Image</label>
                        <input type="file" class="form-control" id="editImage" name="image" accept="image/*">
                        <input type="hidden" id="editImagePath" name="image_path">
                    </div>
                    <div class="mb-3">
                        <label for="editDate" class="form-label">Date</label>
                        <input type="date" class="form-control" id="editDate" name="date">
                    </div>
                    <button type="submit" class="btn btn-primary" name="edit_book">Update Book</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const editBookModal = document.getElementById('editBookModal');
    editBookModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const bookId = button.getAttribute('data-id');
        const bookName = button.getAttribute('data-name');
        const category = button.getAttribute('data-category');
        const image = button.getAttribute('data-image');
        const date = button.getAttribute('data-date');

        const modal = editBookModal.querySelector('form');
        modal.querySelector('#editBookId').value = bookId;
        modal.querySelector('#editBookName').value = bookName;
        modal.querySelector('#editCategory').value = category;
        modal.querySelector('#editImagePath').value = image;
        modal.querySelector('#editDate').value = date;
    });
</script>
</body>
</html>
