<?php
require('dbconnection.php');

if (isset($_POST['update-account'])) {
    $admin_id = $_POST['admin_id'];
    $admin_name = $_POST['admin_name'];
    $email = $_POST['email'];
    $mobile_number = $_POST['mobile_number'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $update_admin_account = "UPDATE admin_tbl SET admin_name = ?, email = ?, mobile_number = ?, username = ?, password = ? WHERE admin_id = ?";
    $stmt = $connect->prepare($update_admin_account);
    $stmt->bind_param("sssssi", $admin_name, $email, $mobile_number, $username, $password, $admin_id);
    if ($stmt->execute()) {
        echo "<script>
                alert('Account Updated Successfully');
                window.location = 'admin_settings.php';
              </script>";
    } else {
    }
    $stmt->close();
    $connect->close();
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/admin_settings.css">
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
            <span class="text">SETTINGS</span>
        </div>
        <div class="button">
            <!-- <button id="btn-add">𓂃🖊 BOOK</button> -->
             <div>
                <button class="add-book-btn" id="edit-account" data-bs-toggle="modal" data-bs-target="#addBookModal">𓂃🖊 ACCOUNT</button>
            </div>
        </div>
            <div class="content">
                <div class="admin-form">
                    <div class="adminform-header">
                        <span>Account Settings</span>
                    </div>                    
                    <div class="form-field">
                        <div>
                            <label>Name :</label>
                            <input type="text" value="<?= $admin_name ?>" readonly>
                        </div>
                        <div>
                            <label>Email :</label>
                            <input type="email" value="<?= $email ?>" readonly>
                        </div>
                        <div>
                            <label>Mobile Number :</label>
                            <input type="text" value="<?= $mobile_number ?>" readonly>
                        </div>
                        <div>
                            <label>Username :</label>
                            <input type="text" value="<?= $username ?>" readonly>
                        </div>
                        <div class="password-form">
                            <label>Password :</label>
                            <input type="password" id="passwordField" value="<?= $password ?>" readonly>
                            <img src="image/eye.png" id="togglePassword" alt="See password" width="20">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div id="add-modal" class="add-modal">
            <div class="add-modal-content">
                <span class="add-close">&times;</span>
                <div class="header">
                    <h2>Personal Details</h2>
                </div>
                <form action="#" method="POST">
                    <input type="hidden" name="admin_id" value="<?= $admin_id ?>">
                    <div class="add-form">
                        <div>
                            <span>Name :</span>
                            <input type="text" name="admin_name" value="<?= $admin_name ?>">
                        </div>                        
                        <div>
                            <span>Email :</span>
                            <input type="text" name="email" value="<?= $email ?>">
                        </div>
                        <div>
                            <span>Mobile Number :</span>
                            <input class="input" type="text" name="mobile_number" id="mobileNumber" maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 11);" value="<?= $mobile_number ?>">
                            </div>
                        <div>
                            <span>Username :</span>
                            <input type="text" name="username" value="<?= $username ?>">
                        </div>
                        <div class="password-form">
                            <label>Password :</label>
                            <input type="password" name="password" id="passwordField_edit" value="<?= $password ?>">
                            <img src="image/eye.png" id="togglePassword_edit" alt="See password" width="20">
                        </div>
                        <div class="submit-btn">
                            <input type="submit" name="update-account" value="Update">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <script src="js/dashboard.js"></script>
    <script>
        var modal = document.getElementById("add-modal");

        var btn = document.getElementById("edit-account");

        var span = document.getElementsByClassName("add-close")[0];

        btn.onclick = function() {
        modal.style.display = "block";
        }

        span.onclick = function() {
        modal.style.display = "none";
        }

        window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "block";
            }
        }

        var togglePassword1 = document.getElementById("togglePassword");
        var passwordField1 = document.getElementById("passwordField");

        togglePassword1.addEventListener('click', function () {
            if (passwordField1.type === "password") {
                passwordField1.type = "text";
                togglePassword1.src = "image/close-eye.png";
            } else {
                passwordField1.type = "password";
                togglePassword1.src = "image/eye.png";
            }
        });

        var togglePassword2 = document.getElementById("togglePassword_edit");
        var passwordField2 = document.getElementById("passwordField_edit");

        togglePassword2.addEventListener('click', function () {
            if (passwordField2.type === "password") {
                passwordField2.type = "text";
                togglePassword2.src = "image/close-eye.png";
            } else {
                passwordField2.type = "password";
                togglePassword2.src = "image/eye.png";
            }
        });
    </script>
</body>
</html>