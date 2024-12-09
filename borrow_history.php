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

    <link rel="stylesheet" href="css/borrow_book.css">
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
            <span class="text">BORROW HISTORY</span>
        </div>
        <div class="button">
            <!-- <button id="btn-add">𓂃🖊 BOOK</button> -->
             <!-- <div>
                <button class="add-book-btn" data-bs-toggle="modal" data-bs-target="#addBookModal">𓂃🖊 BOOK</button>
            </div> -->
            <div>
                <input type="search" class="form-control" id="myInput" onkeyup="myFunction()" placeholder="Search for Student ID" title="Type in a name">
            </div>
        </div>

        <div class="content">
        <div class="table-container">
                <table id="myTable">
                    <tr>
                        <th>NO.</th>
                        <th>STUDENT ID</th>
                        <th>NAME</th>
                        <th>COURSE (YEAR/SECTION)</th>
                        <th>BOOK CATEGORY</th>
                        <th>BOOK TITLE</th>
                        <th>BORROW DATE</th>
                        <th>RETURN DATE</th>
                        <th>Status</th>
                    </tr>
                    <?php
                        require('dbconnection.php');
                        $sql = "SELECT * FROM borrow_tbl WHERE status IN ('Borrowed', 'Cancelled') ORDER BY borrow_id DESC";
                        $result = $connect->query($sql);
                        
                        if ($result->num_rows > 0) {
                            $counter = 1;
                            while ($row = $result->fetch_assoc()) {
                                $statusStyle = $row['status'] === 'Borrowed' ? 'btn-success' : ($row['status'] === 'Cancelled' ? 'btn-danger' : '');
                                
                                echo "<tr id='row-" . $row['borrow_id'] . "'>";
                                echo "<td>" . $counter . "</td>";
                                echo "<td class='td'>" . htmlspecialchars($row["student_uid"], ENT_QUOTES, 'UTF-8') . "</td>";
                                echo "<td class='td'>" . htmlspecialchars($row["student_name"], ENT_QUOTES, 'UTF-8') . "</td>";
                                echo "<td class='td'>" . htmlspecialchars($row["student_course"], ENT_QUOTES, 'UTF-8') . " (" . 
                                    htmlspecialchars($row["student_year"], ENT_QUOTES, 'UTF-8') . " - " . 
                                    htmlspecialchars($row["student_section"], ENT_QUOTES, 'UTF-8') . ")</td>";
                                echo "<td>" . htmlspecialchars($row["book_category"], ENT_QUOTES, 'UTF-8') . "</td>";
                                echo "<td class='td'>" . htmlspecialchars($row["book_title"], ENT_QUOTES, 'UTF-8') . "</td>";
                                echo "<td>" . htmlspecialchars($row["date_borrow"], ENT_QUOTES, 'UTF-8') . "</td>";
                                echo "<td>" . htmlspecialchars($row["date_return"], ENT_QUOTES, 'UTF-8') . "</td>";
                                
                                echo "<td><span class='btn $statusStyle'>" . htmlspecialchars($row["status"], ENT_QUOTES, 'UTF-8') . "</span></td>";
                                
                                echo "</tr>";
                                $counter++;
                            }
                        } else {
                            echo "<tr><td colspan='12'>No records found</td></tr>";
                        }
                        
                        $connect->close();
                        
                    ?>
                </table>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function myFunction() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[1];
                    if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }       
            }
        }
    </script>
</body>
</html>