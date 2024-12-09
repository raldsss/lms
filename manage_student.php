<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/manage_student.css">
    <title>Student - Library Management System</title>
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
                <li><a class="link_name" href="#">Students</a></li>
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
            <span class="text">STUDENT</span>
        </div>
        <div class="button">
            <!-- <button id="btn-add">𓂃🖊 BOOK</button> -->
             <div>
                <button class="add-book-btn" data-bs-toggle="modal" data-bs-target="#addBookModal">𓂃🖊 STUDENT</button>
            </div>
            <div>
                <input type="search" class="form-control" id="myInput" onkeyup="myFunction()" placeholder="Search for student id.." title="Type in a name">
                <!-- <input type="search" class="form-control" id="search-student" placeholder="Search Student"> -->
            </div>
        </div>
        <?php
            require('dbconnection.php');

            $query = "SELECT * FROM student_tbl";
            $result = $connect->query($query);
        ?>

        <div class="content">
            <div class="table-container">
                <table id="myTable">
                    <tr>
                        <th>ID</th>
                        <th>NAME</th>
                        <th>COURSE/YEAR/SECTION</th>
                        <th>STUDENT UID</th>
                        <th>CODE</th>
                        <th>ACTION</th>
                    </tr>
                    <?php
                        require('dbconnection.php');
                        $sql = "SELECT * FROM student_tbl ORDER BY student_id DESC";
                        $result = $connect->query($sql);
                        if ($result->num_rows > 0) {
                            $counter = 1;
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $counter . "</td>";
                                echo "<td>" . htmlspecialchars($row["student_name"], ENT_QUOTES, 'UTF-8') . "</td>";
                                echo "<td>" . htmlspecialchars($row["student_course"], ENT_QUOTES, 'UTF-8') . " (" . 
                                    htmlspecialchars($row["student_year"], ENT_QUOTES, 'UTF-8') . " - " . 
                                    htmlspecialchars($row["student_section"], ENT_QUOTES, 'UTF-8') . ")</td>";
                                echo "<td>" . htmlspecialchars($row["student_uid"], ENT_QUOTES, 'UTF-8') . "</td>";
                                echo "<td>" . htmlspecialchars($row["student_password"], ENT_QUOTES, 'UTF-8') . "</td>";
                                echo "<td>
                                        <button 
                                            class='btn btn-danger' 
                                            onclick='confirmDelete(\"" . $row["student_id"] . "\", \"" . htmlspecialchars($row["student_name"], ENT_QUOTES, 'UTF-8') . "\")'>
                                            Delete
                                        </button>
                                    </td>";
                                // echo "<td>
                                //         <button 
                                //             class='btn btn-primary' 
                                //             onclick='openEditModal(
                                //                 \"" . $row["student_id"] . "\", 
                                //                 \"" . htmlspecialchars($row["student_name"], ENT_QUOTES, 'UTF-8') . "\", 
                                //                 \"" . htmlspecialchars($row["student_course"], ENT_QUOTES, 'UTF-8') . "\", 
                                //                 \"" . htmlspecialchars($row["student_year"], ENT_QUOTES, 'UTF-8') . "\", 
                                //                 \"" . htmlspecialchars($row["student_section"], ENT_QUOTES, 'UTF-8') . "\", 
                                //                 \"" . htmlspecialchars($row["student_uid"], ENT_QUOTES, 'UTF-8') . "\"
                                //             )'>
                                //             Edit
                                //         </button>
                                //       </td>";
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
                    <h2 class="modal-title" id="addBookModalLabel">Add a New Student</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="dbstudent.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="admin_id" value="<?= $admin_id; ?>">
                        <input type="hidden" name="admin_name" value="<?= $admin_name; ?>">
                        <div class="mb-3">
                            <label for="student_uid" class="form-label">Student ID</label>
                            <input type="text" class="form-control" id="student_uid" name="student_uid" required>
                            <!-- <input  class="form-control" type="text" name="isbn" id="isbn" maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 11);" required> -->
                        </div>
                        <div class="mb-3">
                            <label for="student_name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="student_name" name="student_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="student_course" class="form-label">Course</label>
                            <input type="text" class="form-control" id="student_course" name="student_course" required>
                        </div>
                        <div class="mb-3">
                            <label for="student_year" class="form-label">Year</label>
                            <input type="text" class="form-control" id="student_year" name="student_year" oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 1);" required>
                        </div>
                        <div class="mb-3">
                            <label for="student_section" class="form-label">Section</label>
                            <input type="text" class="form-control" id="student_section" name="student_section" required>
                        </div>
                        <div class="mb-3">
                            <?php
                                function generateRandomPassword($length = 6) {
                                    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                                    $password = '';
                                    for ($i = 0; $i < $length; $i++) {
                                        $password .= $characters[random_int(0, strlen($characters) - 1)];
                                    }
                                    return $password;
                                }

                                $randomPassword = generateRandomPassword();
                            ?>
                            <!-- <label for="generatedPassword">Generated Code:</label> -->
                            <input type="hidden" class="form-control" name="student_password" id="generatedPassword" value="<?= $randomPassword ?>" readonly>
                        </div>
                        <button type="submit" class="btn btn-primary" name="add_book">Add Student</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="editStudentModalLabel">Edit Student</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editStudentForm" action="update_student.php" method="POST">
                        <input type="hidden" id="edit_student_id" name="student_id">
                        <div class="mb-3">
                            <label for="edit_student_name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="edit_student_name" name="student_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_student_course" class="form-label">Course</label>
                            <input type="text" class="form-control" id="edit_student_course" name="student_course" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_student_year" class="form-label">Year</label>
                            <input type="text" class="form-control" id="edit_student_year" name="student_year" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_student_section" class="form-label">Section</label>
                            <input type="text" class="form-control" id="edit_student_section" name="student_section" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_student_uid" class="form-label">Student ID</label>
                            <input type="text" class="form-control" id="edit_student_uid" name="student_uid" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_student_password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="edit_student_password" name="student_password">
                            <small class="text-muted">Leave blank to keep the current password.</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/dashboard.js"></script>
    <script>
        function myFunction() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[3];
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

        function openEditModal(student_id, student_name, student_course, student_year, student_section, student_uid) {
            document.getElementById('edit_student_id').value = student_id;
            document.getElementById('edit_student_name').value = student_name;
            document.getElementById('edit_student_course').value = student_course;
            document.getElementById('edit_student_year').value = student_year;
            document.getElementById('edit_student_section').value = student_section;
            document.getElementById('edit_student_uid').value = student_uid;

            const editModal = new bootstrap.Modal(document.getElementById('editStudentModal'));
            editModal.show();
        }

        function confirmDelete(studentId, studentName) {
            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to delete "${studentName}". This action cannot be undone!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to delete_student.php with studentId
                    window.location.href = "delete_student.php?id=" + studentId;
                }
            });
        }

    </script>
</body>
</html>