<?php
include('dbconnection.php');

// Fetch categories
$categoryQuery = "SELECT DISTINCT book_category FROM book_tbl";
$categoriesResult = mysqli_query($connect, $categoryQuery);

if (!$categoriesResult) {
    die("Error fetching categories: " . mysqli_error($connect));
}

// Fetch books based on selected category
$selectedCategory = isset($_GET['book_category']) ? $_GET['book_category'] : 'All';
$bookQuery = $selectedCategory === 'All'
    ? "SELECT * FROM book_tbl"
    : "SELECT * FROM book_tbl WHERE book_category = '" . mysqli_real_escape_string($connect, $selectedCategory) . "'";
$booksResult = mysqli_query($connect, $bookQuery);

if (!$booksResult) {
    die("Error fetching books: " . mysqli_error($connect));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['borrow_book'])) {
    $book_id = isset($_POST['book_id']) ? intval($_POST['book_id']) : 0;
    $borrower_name = mysqli_real_escape_string($connect, $_POST['borrower_name']);
    $borrower_email = mysqli_real_escape_string($connect, $_POST['borrower_email']);
    $book_name = mysqli_real_escape_string($connect, $_POST['book_name']);
    $copies = intval($_POST['copies']);
    $borrow_date = mysqli_real_escape_string($connect, $_POST['borrow_date']);
    $return_date = mysqli_real_escape_string($connect, $_POST['return_date']);
    $status = mysqli_real_escape_string($connect, $_POST['status']);

    $stmt = $connect->prepare("
        INSERT INTO borrow_books (book_id, borrower_name, borrower_email, book_name, copies, borrow_date, return_date, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("isssssss", $book_id, $borrower_name, $borrower_email, $book_name, $copies, $borrow_date, $return_date, $status);

    if ($stmt->execute()) {
        echo "<script>
                alert('Submit successfully! Please wait until the approval.');
                window.location.href = 'student_books.php';
              </script>";
    } else {
        echo "<script>
                alert('Failed to borrow. Please try again.');
                window.location.href = 'student_books.php';
              </script>";
    }

    $stmt->close();
}

$connect->close();
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
</head>
<body>
  <nav>
    <a href="home.php" class="nav-link"><i class="fas fa-home"></i></a>
    <a href="#" class="nav-link active"><i class="fas fa-book"></i></a>
    <a href="#" class="nav-link"><i class="fas fa-history"></i></a>
    <a href="useraccount.php" class="nav-link"><i class="fas fa-user"></i></a>
    <a href="#" class="nav-link"><i class="fas fa-sign-out-alt"></i></a>
  </nav>

  <main>
    <header>
      <h1>Books</h1>
    </header>

    <div class="categories">
      <button class="category <?php echo ($selectedCategory === 'All') ? 'active' : ''; ?>" onclick="window.location.href='?book_category=All'">All</button>
      <?php while ($categoryRow = mysqli_fetch_assoc($categoriesResult)): ?>
        <button class="category <?php echo ($selectedCategory === $categoryRow['book_category']) ? 'active' : ''; ?>" 
                onclick="window.location.href='?book_category=<?php echo urlencode($categoryRow['book_category']); ?>'">
          <?php echo htmlspecialchars($categoryRow['book_category']); ?>
        </button>
      <?php endwhile; ?>
    </div>

    <div class="product-list">
      <?php if (mysqli_num_rows($booksResult) > 0): ?>
        <?php while ($bookRow = mysqli_fetch_assoc($booksResult)): ?>
          <?php 
          // Check if image exists in the 'uploads' folder
          $imagePath = 'uploads/' . $bookRow['image'];
          if (file_exists($imagePath)): ?>
            <div class="product-card" 
                 onclick="showDetails('<?php echo $imagePath; ?>', 
                                      '<?php echo addslashes($bookRow['book_title']); ?>', 
                                      'Author: <?php echo addslashes($bookRow['book_author']); ?>',
                                      'Publisher: <?php echo addslashes($bookRow['publisher']); ?>',
                                      'Publication Year: <?php echo addslashes($bookRow['publication_year']); ?>',
                                      'Copies Available: <?php echo addslashes($bookRow['copies_available']); ?>',
                                      'Total Copies: <?php echo addslashes($bookRow['total_copies']); ?>')">
              <img src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($bookRow['book_title']); ?>">
              <h3><?php echo htmlspecialchars($bookRow['book_title']); ?></h3>
            </div>
          <?php else: ?>
            <p>Image not available</p> <!-- Optional fallback if image is missing -->
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
    <p id="detailsPublisher"></p> <!-- Publisher information -->
    <p id="detailsPubYear"></p> <!-- Publication Year -->
    <p id="detailsCopies"></p> <!-- Copies Available -->
    <p id="detailsTotalCopies"></p> <!-- Total Copies --> <!-- Add this line for Total Copies -->
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#borrowModal">
      <i class="fas fa-external-link-alt"></i> Borrow
    </button>
  </div>

<!-- Borrow Modal -->
<div class="modal fade" id="borrowModal" tabindex="-1" aria-labelledby="borrowModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="borrowModalLabel">Borrow Book</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="borrowForm" method="POST" action="student_books.php">
          <div class="mb-3">
            <label for="exampleInputName" class="form-label">Name</label>
            <input type="text" class="form-control" id="exampleInputName" name="borrower_name">
          </div>

          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email</label>
            <input type="email" class="form-control" id="exampleInputEmail1" name="borrower_email">
          </div>

          <div class="mb-3">
            <label for="exampleInputBookname" class="form-label">Book Name</label>
            <input type="text" class="form-control" id="exampleInputBookname" name="book_name" readonly>
          </div>

          <div class="mb-3">
            <label for="exampleInputCopies" class="form-label">Copies</label>
            <input type="number" class="form-control" id="exampleInputCopies" name="copies">
          </div>

          <div class="mb-3">
            <label for="exampleInputDate" class="form-label">Borrow Date</label>
            <input type="date" class="form-control" id="exampleInputDate" name="borrow_date">
          </div>

          <div class="mb-3">
            <label for="exampleInputReturn" class="form-label">Return Date</label>
            <input type="date" class="form-control" id="exampleInputReturn" name="return_date">
          </div>

          <input type="hidden" name="status" value="pending"> <!-- Status field -->
          <button type="submit"  name="submit" class="btn btn-primary">Confirm Borrow</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>





  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

  <script>
    function showDetails(image, title, description, publisher, pubYear, copies, totalCopies) {
  // Populate the details panel
  document.getElementById('detailsImage').src = image;
  document.getElementById('detailsTitle').textContent = title;
  document.getElementById('detailsDescription').textContent = description;
  document.getElementById('detailsPublisher').textContent = publisher;
  document.getElementById('detailsPubYear').textContent = pubYear;
  document.getElementById('detailsCopies').textContent = copies;
  document.getElementById('detailsTotalCopies').textContent = ' ' + totalCopies;

  // Populate the 'Book Name' input in the modal
  document.getElementById('exampleInputBookname').value = title;

  // Show the details panel
  document.getElementById('detailsPanel').classList.add('active');
}
function closeDetails() {
      document.getElementById('detailsPanel').classList.remove('active');
    }

    

  </script>
</body>
</html>
