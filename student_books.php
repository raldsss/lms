<?php
require('dbconnection.php');

$categoriesQuery = "SELECT DISTINCT book_category FROM book_tbl";
$categoriesResult = $connect->query($categoriesQuery);

if (!$categoriesResult) {
    die("Error fetching categories: " . $connect->error);
}

$selectedCategory = isset($_GET['book_category']) ? $_GET['book_category'] : 'All';

if ($selectedCategory === 'All') {
    $booksQuery = "SELECT * FROM book_tbl";
} else {
    $booksQuery = "SELECT * FROM book_tbl WHERE book_category = '" . $connect->real_escape_string($selectedCategory) . "'";
}

$booksResult = $connect->query($booksQuery);

if (!$booksResult) {
    die("Error fetching books: " . $connect->error);
}


if (isset($_POST['submit'])) {
    $book_id = $_POST['book_id'];
    $admin_id = $_POST['admin_id'];
    $admin_name = $_POST['admin_name'];
    $student_name = $_POST['student_name'];
    $student_uid = $_POST['student_uid'];
    $student_id = $_POST['student_id'];
    $book_category = $_POST['book_category'];
    $book_title = $_POST['book_title'];
    $student_course = $_POST['student_course'];
    $student_year = $_POST['student_year'];
    $student_section = $_POST['student_section'];
    $borrow_quantity = $_POST['borrow_quantity'];
    $date_borrow = $_POST['date_borrow'];
    $date_return = $_POST['date_return'];
    $status = $_POST['status'];
    $datetime = $_POST['datetime'];

    if (empty($book_id) || empty($student_name) || empty($student_uid) || empty($book_title) || empty($borrow_quantity) || empty($date_borrow) || empty($date_return)) {
        echo "<script>alert('All fields are required!'); window.history.back();</script>";
        exit();
    }

    $check_book_query = "SELECT copies_available FROM book_tbl WHERE book_id = '$book_id'";
    $result = $connect->query($check_book_query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $copies_available = $row['copies_available'];

        if ($borrow_quantity > $copies_available) {
            echo "<script>alert('Not enough copies available! $copies_available copies left.'); window.history.back();</script>";
            exit();
        }
    } else {
        echo "<script>alert('Book not found!'); window.history.back();</script>";
        exit();
    }

    $insert_query = "INSERT INTO borrow_tbl (book_id, admin_id, admin_name, student_name, student_uid, student_id, student_course, student_year, student_section, book_category, book_title, borrow_quantity, date_borrow, date_return, status, datetime) 
                     VALUES ('$book_id', '$admin_id', '$admin_name', '$student_name', '$student_uid', '$student_id', '$student_course', '$student_year', '$student_section', '$book_category', '$book_title', '$borrow_quantity', '$date_borrow', '$date_return', '$status', '$datetime')";

    if ($connect->query($insert_query)) {
        $update_query = "UPDATE book_tbl SET copies_available = copies_available - $borrow_quantity WHERE book_id = '$book_id'";
        $connect->query($update_query);

        echo "<script>alert('Book borrowed successfully!'); window.location='student_books.php';</script>";
    } else {
        echo "<script>alert('Error borrowing the book. Please try again.'); window.history.back();</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>
    <link rel="stylesheet" href="css/student_books.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head> 

<body>
    <?php
        include('getstudentname.php');
    ?>
    <nav>
    <a href="home.php"  class="nav-link" style="position:relative;left:-5rem; padding:5px; font-size:20px;"><i class="fa fa-user-circle" id="name"></i><span style="position:relative; top:-2px; font-size: 13px; padding:10px;" id="name"><?= $student_name ?></span></a>
        <!-- <button class="btn btn-primary" onclick="window.location='home.php'"><?= $student_name ?></button> -->
        <a href="home.php" class="nav-link active"><i class="fas fa-home"></i></a>
        <a href="student_books.php" class="nav-link"><i class="fas fa-book"></i></a>
        <a href="history.php" class="nav-link"><i class="fas fa-history"></i></a>
        <a href="userinfo.php" class="nav-link"><i class="fas fa-user"></i></a>
        <a href="#" id="logout-link" class="nav-link"><i class="fas fa-sign-out-alt"></i></a>
    </nav>

    <main>
    <header>
        <h1>Books</h1>
        <div class="search-container">
            <input type="text" id="bookSearch" class="form-control mb-3" placeholder="Search">
            <p id="noBooksMessage" style="display: none; color: red; font-weight: bold;">No books found</p>
        </div>

    

        <div class="categories">
            <button class="category <?php echo ($selectedCategory === 'All') ? 'active' : ''; ?>" onclick="window.location.href='?book_category=All'">All</button>
            <?php while ($categoryRow = mysqli_fetch_assoc($categoriesResult)): ?>
            <button class="category <?php echo ($selectedCategory === $categoryRow['book_category']) ? 'active' : ''; ?>" 
                onclick="window.location.href='?book_category=<?php echo urlencode($categoryRow['book_category']); ?>'">
                <?php echo htmlspecialchars($categoryRow['book_category']); ?>
            </button>
            <?php endwhile; ?>
        </div>

    </header>
    <div class="product-list">
        <?php if (mysqli_num_rows($booksResult) > 0): ?>
            <?php while ($bookRow = mysqli_fetch_assoc($booksResult)): ?>
                <?php 
                    $imagePath = 'uploads/' . $bookRow['image'];
                    if (file_exists($imagePath)): 
                ?>
                <div class="product-card" 
                    onclick="showDetails(
                        '<?php echo $imagePath; ?>', 
                        '<?php echo addslashes($bookRow['book_title']); ?>', 
                        'Author: <?php echo addslashes($bookRow['book_author']); ?>',
                        'Publisher: <?php echo addslashes($bookRow['publisher']); ?>',
                        'Publication Year: <?php echo addslashes($bookRow['publication_year']); ?>',
                        'Available: <?php echo $bookRow['copies_available']; ?>',
                        '<?php echo addslashes($bookRow['book_id']); ?>',
                        '<?php echo addslashes($bookRow['book_category']); ?>')">
                    <img src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($bookRow['book_title']); ?>">
                    <h3><?php echo htmlspecialchars($bookRow['book_title']); ?></h3>
                </div>

                <?php else: ?>
                <p>Image not available</p> 
                <?php endif; ?>
                <?php endwhile; ?>
                <?php else: ?>
                <p>No books found in this category.</p>
            <?php endif; ?>
        </div>
    </main>

    <div class="details-panel" id="detailsPanel">
        <button class="close-btn" onclick="closeDetails()">&times;</button>
        <img id="detailsImage" src="" alt="">
        <h3 id="detailsTitle"></h3><hr>
        <p id="detailsDescription"></p>
        <p id="detailsPublisher"></p>
        <p id="detailsPubYear"></p> 
        <p id="detailsCopies"></p>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#borrowModal">
        <i class="fas fa-external-link-alt"></i> Borrow
        </button>
    </div>
    <?php
        require('dbconnection.php');

        $adminQuery = "SELECT admin_id, admin_name FROM admin_tbl";
        $adminResult = $connect->query($adminQuery);

        $admins = [];

        if ($adminResult->num_rows > 0) {
            while ($row = $adminResult->fetch_assoc()) {
                $admins[] = [
                    'admin_id' => $row['admin_id'],
                    'admin_name' => $row['admin_name']
                ];
            }
        }

        $connect->close();

        foreach ($admins as $admin) {
            // echo "Admin ID: " . htmlspecialchars($admin['admin_id']) . "<br>";
            // echo "Admin Name: " . htmlspecialchars($admin['admin_name']) . "<br><hr>";
        }
    ?>


    <div class="modal fade" id="borrowModal" tabindex="-1" aria-labelledby="borrowModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="borrowModalLabel">Borrow Book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="borrowForm" method="POST" action="student_books.php">
                        <input type="hidden" name="book_id">
                        <input type="hidden" name="admin_id" value="<?= htmlspecialchars($admin['admin_id']) ?>">
                        <input type="hidden" name="admin_name" value="<?= htmlspecialchars($admin['admin_name']) ?>">
                        <input type="hidden" name="student_id" value="<?= $student_id ?>">
                        <input type="hidden" name="student_course" value="<?= $student_course ?>">
                        <input type="hidden" name="student_year" value="<?= $student_year ?>">
                        <input type="hidden" name="student_section" value="<?= $student_section ?>">

                        <div class="mb-3">
                            <label for="exampleInputName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="exampleInputName" name="student_name" value="<?= $student_name ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputName" class="form-label">Student ID</label>
                            <input type="text" class="form-control" id="exampleInputName" name="student_uid" value="<?= $student_uid ?>" readonly>
                        </div>
                        
                        <div class="mb-3">
                            <label for="exampleInputCategory" class="form-label">Category</label>
                            <input type="text" class="form-control" id="exampleInputCategory" name="book_category" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputBookname" class="form-label">Book Name</label>
                            <input type="text" class="form-control" id="exampleInputBookname" name="book_title" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputCopies" class="form-label">Copies</label>
                            <input type="number" class="form-control" id="exampleInputCopies" name="borrow_quantity" min="1" required>
                        </div>


                        <div class="mb-3">
                            <label for="exampleInputDate" class="form-label">Borrow Date</label>
                            <input type="date" class="form-control" id="exampleInputDate" name="date_borrow">
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputReturn" class="form-label">Return Date</label>
                            <input type="date" class="form-control" id="exampleInputReturn" name="date_return">
                        </div>

                        <input type="hidden" name="status" value="Pending">

                        <input type="hidden" id="datetime" class="form-control" name="datetime">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="submit" class="btn btn-primary">Confirm Borrow</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="js/student_books.js"></script>
    <script>
        document.getElementById('logout-link').addEventListener('click', function(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "You will be logged out!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, log out!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'logout.php';
            }
        });
        });

        function updateDateTime() {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');

            const formattedDateTime = `${year}-${month}-${day}T${hours}:${minutes}:${seconds}`;
            document.getElementById('datetime').value = formattedDateTime;
        }

        setInterval(updateDateTime, 1000);
        updateDateTime();
    </script>
</body>
</html>
