<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> -->

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
                <a href="book_category.php">
                    <i class="bx bx-collection"></i>
                    <span class="link_name">Books</span>
                </a>
                <i class="bx bxs-chevron-down arrow"></i>
                </div>
                <ul class="sub-menu">
                <li><a class="link_name" href="book_category.php">Books</a></li>
                <li><a href="borrow_notification.php">Borrow Notification</a></li>
                <li><a href="borrow_history.php">Borrow History</a></li>
                </ul>
            </li>
            <li>
                <a href="manage_student.php">
                <i class="bx bx-user"></i>
                <span class="link_name">Students</span>
                </a>
                <ul class="sub-menu blank">
                <li><a class="link_name" href="manage_student.php">Students</a></li>
                </ul>
            </li>
            <li>
                <a href="admin_settings.php">
                <i class="bx bx-cog"></i>
                <span class="link_name">Setting</span>
                </a>
                <ul class="sub-menu blank">
                <li><a class="link_name" href="admin_settings.php">Setting</a></li>
                </ul>
            </li>
            <li>
                <a href="#" id="logout-link">
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
                </a>
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

            $query = "SELECT * FROM book_tbl";
            $result = $connect->query($query);
        ?>

        <div class="content">
            <div class="grid-books">
                <?php
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $bookID = htmlspecialchars($row['book_id'], ENT_QUOTES, 'UTF-8');
                        $bookTitle = htmlspecialchars($row['book_title'], ENT_QUOTES, 'UTF-8');
                        $bookStatus = htmlspecialchars($row['status'], ENT_QUOTES, 'UTF-8');
                        $bookCopies = htmlspecialchars($row['copies_available'], ENT_QUOTES, 'UTF-8');
                        $booktotalCopies = htmlspecialchars($row['total_copies'], ENT_QUOTES, 'UTF-8');
                        $bookAuthor = htmlspecialchars($row['book_author'], ENT_QUOTES, 'UTF-8');
                        $bookCategory = htmlspecialchars($row['book_category'], ENT_QUOTES, 'UTF-8');
                        $publisher = htmlspecialchars($row['publisher'], ENT_QUOTES, 'UTF-8');
                        $publicationYear = htmlspecialchars($row['publication_year'], ENT_QUOTES, 'UTF-8');
                        $isbn = htmlspecialchars($row['isbn'], ENT_QUOTES, 'UTF-8');
                        $image = $row['image'] ? 'uploads/' . htmlspecialchars($row['image'], ENT_QUOTES, 'UTF-8') : 'default-book.png';

                        echo "
                        <button class='book-item btn' 
                                data-toggle='modal' 
                                data-target='#newPage' 
                                data-bookID='$bookID' 
                                data-title='$bookTitle' 
                                data-copies='$bookCopies' 
                                data-totalcopies='$booktotalCopies' 
                                data-status='$bookStatus' 
                                data-author='$bookAuthor' 
                                data-category='$bookCategory' 
                                data-publisher='$publisher' 
                                data-publishYear='$publicationYear' 
                                data-isbn='$isbn' 
                                data-image='$image'>
                            <img src='$image' alt='$bookTitle' class='book-image'>
                            <label class='book-title'>$bookTitle</label><br>
                            <span class='s-book'>$bookCopies  $bookStatus</span>
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

    <div class="modal fade" id="newPage" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"></h5>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <form id="updateBookForm" method="POST" action="update_book.php">
                    <div class="modal-body">
                        <input type="hidden" name="book_id" id="bookidInput">
                        <div>
                            <label for="bookISBN" class="form-label">ISBN</label>
                            <input type="text" name="isbn" id="isbnInput" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="bookTitleInput" class="form-label">Book Title</label>
                            <input type="text" class="form-control" id="bookTitleInput" name="book_title">
                        </div>
                        <div class="mb-3">
                            <label for="bookAuthorInput" class="form-label">Author</label>
                            <input type="text" class="form-control" id="bookAuthorInput" name="book_author">
                        </div>
                        <div class="mb-3">
                            <label for="bookCategoryInput" class="form-label">Category</label>
                            <input type="text" class="form-control" id="bookCategoryInput" name="book_category">
                        </div>
                        <div class="mb-3">
                            <label for="publisherInput" class="form-label">Publisher</label>
                            <input type="text" class="form-control" id="publisherInput" name="publisher">
                        </div>
                        <div class="mb-3">
                            <label for="publicationYearInput" class="form-label">Publication Year</label>
                            <input type="number" class="form-control" id="publicationYearInput" name="publication_year">
                        </div>
                        <div class="mb-3">
                            <label for="availableCopiesInput" class="form-label">Copies Available</label>
                            <input type="number" class="form-control" id="availableCopiesInput" name="available_copies" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="totalCopiesInput" class="form-label">Total Copies</label>
                            <input type="number" class="form-control" id="totalCopiesInput" name="total_copies">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script src="js/dashboard.js"></script>
    <script src="js/book.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    //     document.addEventListener('DOMContentLoaded', () => {
    //     const bookButtons = document.querySelectorAll('.book-item');
    //     const modalTitle = document.querySelector('#newPage .modal-title');
    //     const modalBody = document.querySelector('#newPage .modal-body');
    //     const modalFooter = document.querySelector('#newPage .modal-footer');

    //     bookButtons.forEach(button => {
    //         button.addEventListener('click', () => {
    //             const title = button.getAttribute('data-title');
    //             const copies = button.getAttribute('data-copies');
    //             // const status = button.getAttribute('data-status');
    //             const author = button.getAttribute('data-author');
    //             const category = button.getAttribute('data-category');
    //             const publisher = button.getAttribute('data-publisher');
    //             const publicationYear = button.getAttribute('data-publishYear');
    //             const image = button.getAttribute('data-image');

    //             modalTitle.textContent = title;
    //             modalBody.innerHTML = `
    //                 <img src="${image}" alt="${title}" class="book-image-modal">
    //                 <p class='status-available'><strong>Category:</strong> ${category}</p>
    //                 <p><strong>Author:</strong> ${author}</p>
    //                 <p><strong>Publisher:</strong> ${publisher}</p>
    //                 <p><strong>Year Publish:</strong> ${publicationYear}</p>
    //                 <p><strong>Copies Available:</strong> ${copies}</p>
    //             `;

    //             modalFooter.innerHTML = `
    //                 <button class='btn btn-primary'>Update</button>
    //             `;
    //         });
    //     });
    // });

    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('search-book');
        const bookItems = document.querySelectorAll('.book-item');

        searchInput.addEventListener('input', () => {
            const searchValue = searchInput.value.toLowerCase();

            bookItems.forEach(item => {
                const title = item.getAttribute('data-title').toLowerCase();
                const isbn = item.getAttribute('data-isbn').toLowerCase();

                if (title.includes(searchValue) || isbn.includes(searchValue)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });


    document.addEventListener('DOMContentLoaded', () => {
        const bookButtons = document.querySelectorAll('.book-item');
        const modalTitle = document.querySelector('#modalTitle');
        const updateForm = document.querySelector('#updateBookForm');

        bookButtons.forEach(button => {
            button.addEventListener('click', () => {
                const title = button.getAttribute('data-title');
                const copies = button.getAttribute('data-copies');
                const author = button.getAttribute('data-author');
                const category = button.getAttribute('data-category');
                const publisher = button.getAttribute('data-publisher');
                const publicationYear = button.getAttribute('data-publishYear');
                const isbn = button.getAttribute('data-isbn');
                const totalcopies = button.getAttribute('data-totalcopies');
                const bookID = button.getAttribute('data-bookID');

                modalTitle.textContent = `Update: ${title}`;
                updateForm.querySelector('#bookidInput').value = bookID;
                updateForm.querySelector('#bookidInput').value = bookID;
                updateForm.querySelector('#isbnInput').value = isbn;
                updateForm.querySelector('#bookTitleInput').value = title;
                updateForm.querySelector('#bookAuthorInput').value = author;
                updateForm.querySelector('#bookCategoryInput').value = category;
                updateForm.querySelector('#publisherInput').value = publisher;
                updateForm.querySelector('#publicationYearInput').value = publicationYear;
                updateForm.querySelector('#availableCopiesInput').value = copies;
                updateForm.querySelector('#totalCopiesInput').value = totalcopies;
            });
        });
    });
</script>
</body>
</html>