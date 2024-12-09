<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <link rel="stylesheet" href="css/dashboard.css">
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
            <span class="text">POPULAR BOOKS</span>
        </div>
        <div class="content">
            
        </div>
    </section>
    <script src="js/dashboard.js"></script>
</body>
</html>