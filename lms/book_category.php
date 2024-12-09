<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/book_category.css">
    <title>Dashboard - Library Management System</title>
</head>
<body>
    <?php
        include ('getadmin.php');
    ?>
    <div class="sidebar close">
        <div class="logo-details">
            <img src="image/lms.png" alt="Library Management System" width=80>
            <span class="logo_name">
                Library Management System
            </span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="dashboard.php">
                <i class="bx bx-grid-alt"></i>
                <span class="link_name">Dashboard</span>
                </a>
                <ul class="sub-menu blank">
                <li><a class="link_name" href="dashboard.php">Dashboard</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                <a href="#">
                    <i class="bx bx-collection"></i>
                    <span class="link_name">Books</span>
                </a>
                <i class="bx bxs-chevron-down arrow"></i>
                </div>
                <ul class="sub-menu">
                <li><a class="link_name" href="#">Books</a></li>
                <li><a href="book_category.php">Category</a></li>
                <li><a href="add-recent-book.php">Recently Added</a></li>
                <li><a href="popular-books.php">Popular Books</a></li>
                <li><a href="borrowed-book.php">Borrowing History</a></li>
                </ul>
            </li>
            <!-- <li>
                <div class="iocn-link">
                <a href="#">
                    <i class="bx bx-book-alt"></i>
                    <span class="link_name">Posts</span>
                </a>
                <i class="bx bxs-chevron-down arrow"></i>
                </div>
                <ul class="sub-menu">
                <li><a class="link_name" href="#">Posts</a></li>
                <li><a href="#">Web Design</a></li>
                <li><a href="#">Login Form</a></li>
                <li><a href="#">Card Design</a></li>
                </ul>
            </li> -->
            <li>
                <a href="#">
                <i class="bx bx-user"></i>
                <span class="link_name">Students</span>
                </a>
                <ul class="sub-menu blank">
                <li><a class="link_name" href="#">Students</a></li>
                </ul>
            </li>
            <li>
                <a href="#">
                <i class="bx bx-cog"></i>
                <span class="link_name">Setting</span>
                </a>
                <ul class="sub-menu blank">
                <li><a class="link_name" href="#">Setting</a></li>
                </ul>
            </li>
            <li>
                <div class="profile-details">
                <div class="profile-content">
                    <img src="image/lms-logo.png" alt="profileImg" />
                </div>
                <div class="name-job">
                    <div class="profile_name"><?= $admin_name ?></div>
                    <h6 class="job">admin</h6>
                </div>  
                <i class="bx bx-log-out"></i>
                </div>
            </li>
        </ul>
    </div>
    <section class="home-section">
        <div class="home-content">
            <i class="bx bx-menu"></i>
            <span class="text">BOOKS</span>
        </div>
        <div class="button">
            <!-- <button id="btn-add">𓂃🖊 BOOK</button> -->
             <div>
                <button class="add-book-btn" data-bs-toggle="modal" data-bs-target="#addBookModal">𓂃🖊 BOOK</button>
            </div>
            <div>
                <input type="search" class="form-control" id="search-book" placeholder="Search book">
            </div>
        </div>
        <?php
            require('dbconnection.php');

            $query = "SELECT book_title, status, image FROM book_tbl";
            $result = $connect->query($query);
        ?>

        <div class="content">
            <div class="grid-books">
                <?php
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $bookTitle = htmlspecialchars($row['book_title'], ENT_QUOTES, 'UTF-8');
                        $bookStatus = htmlspecialchars($row['status'], ENT_QUOTES, 'UTF-8');
                        $image = $row['image'] ? 'uploads/' . htmlspecialchars($row['image'], ENT_QUOTES, 'UTF-8') : 'default-book.png';

                        echo "
                        <button class='book-item'>
                            <img src='$image' alt='$bookTitle' class='book-image'>
                            <label class='book-title'>$bookTitle</label>
                            <span class='s-book'>$bookStatus</span>
                        </button>";
                    }
                } else {
                    echo "<p>No books available to display.</p>";
                }
                ?>
            </div>
        </div>
    </section>
    <div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBookModalLabel">Add a New Book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="dbbook.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="admin_id" value="<?= $admin_id; ?>">
                        <input type="hidden" name="admin_name" value="<?= $admin_name; ?>">
                        <div class="mb-3">
                            <label for="isbn" class="form-label">ISBN</label>
                            <input type="text" class="form-control" id="isbn" name="isbn" required>
                            <!-- <input  class="form-control" type="text" name="isbn" id="isbn" maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 11);" required> -->
                        </div>
                        <div class="mb-3">
                            <label for="book-category" class="form-label">Category</label>
                            <input type="text" class="form-control" id="book-category" name="book_category" required>
                        </div>
                        <div class="mb-3">
                            <label for="book-title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="book-title" name="book_title" required>
                        </div>
                        <div class="mb-3">
                            <label for="book_author" class="form-label">Author</label>
                            <input type="text" class="form-control" id="book_author" name="book_author" required>
                        </div>
                        <div class="mb-3">
                            <label for="publisher" class="form-label">Publisher</label>
                            <input type="text" class="form-control" id="publisher" name="publisher" required>
                        </div>
                        <div class="mb-3">
                            <label for="year-publish" class="form-label">Year Publish</label>
                            <input type="number" class="form-control" id="year-publish" name="publication_year" min="1900" max="2100" placeholder="YYYY" oninput="this.value = this.value.slice(0, 4)">
                        </div>
                        <div class="mb-3">
                            <label for="copies" class="form-label">Copies</label>
                            <input type="number" class="form-control" id="copies" name="total_copies" required>
                        </div>

                        <!-- Hidden input for copies available (with ID for JavaScript to work) -->
                        <input type="number" class="form-control" id="copies-available" name="copies_available" hidden readonly>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                        </div>
                        <div class="mb-3">
                            <!-- <label for="status" class="form-label">Status</label> -->
                            <input hidden type="text" name="status" value="Available">
                        </div>
                        <div class="mb-3">
                            <!-- <label for="date" class="form-label">Date</label> -->
                            <input hidden type="datetime-local" id="date_added" name="date_added">
                        </div>
                        <button type="submit" class="btn btn-primary" name="add_book">Add Book</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="js/dashboard.js"></script>
    <script src="js/book.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
document.getElementById('copies').addEventListener('input', function() {
    var totalCopies = document.getElementById('copies').value;
    document.getElementById('copies-available').value = totalCopies;
});
</script>

</body>
</html>