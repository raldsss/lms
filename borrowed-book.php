<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <link rel="stylesheet" href="css/dashboard.css">
    <title>Borrowed Books - Library Management System</title>
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
            <span class="text">BOOKS BORROWED</span>
        </div>
        <div class="content">
            <div class="flexbox">
                <div class="card-1">
                    <span>Books Total</span>
                    <div>
                        <span>New and Existing Books</span>
                        <h3>352</h3>
                    </div>
                </div>
                <div class="card-2">
                    <span>Books Borrowed</span>
                    <div>
                        <span>Old & New Books</span>
                        <h3>450,000</h3>
                    </div>
                </div>
                <div class="card-3">
                    <span>This Month's Trend Books</span>
                    <div>
                        <span>New Books</span>
                        <h3>25</h3>
                    </div>
                </div>
                <div class="card-4">
                    <span>This Month's Total Borrowed</span>
                    <div>
                        <span>New & Existing Books</span>
                        <h3>250</h3>
                    </div>
                </div>
                <div class="report-period">
                    <span>Reporting Period:</span>
                    <h4>January 2024 to October 2024</h4>
                </div>
            </div>
            <div>
                <canvas id="myChart" style="width:100%;max-width:600px"></canvas>
            </div>
        </div>
    </section>
    <script>
        const xValues = [January,February,March,April,May,June,July,August,September,October,November,December];
        const yValues = [7,8,8,9,9,9,10,11,14,14,15];

        new Chart("myChart", {
        type: "line",
        data: {
            labels: xValues,
            datasets: [{
            fill: false,
            lineTension: 0,
            backgroundColor: "rgba(0,0,255,1.0)",
            borderColor: "rgba(0,0,255,0.1)",
            data: yValues
            }]
        },
        options: {
            legend: {display: false},
            scales: {
            yAxes: [{ticks: {min: 6, max:16}}],
            }
        }
        });
    </script>
    <script src="js/dashboard.js"></script>
</body>
</html>