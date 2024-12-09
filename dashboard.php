<?php
    require('dbconnection.php');

    $bookQuery = "SELECT book_title, total_copies FROM book_tbl";
    $result = $connect->query($bookQuery);

    $bookTitles = [];
    $totalCopies = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $bookTitles[] = $row['book_title'];
            $totalCopies[] = $row['total_copies'];
        }
    }

    $bookTitlesJson = json_encode($bookTitles);
    $totalCopiesJson = json_encode($totalCopies);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                <a href="book_category.php">
                    <i class="bx bx-collection"></i>
                    <span class="link_name">Books</span>
                </a>
                <i class="bx bxs-chevron-down arrow"></i>
                </div>
                <ul class="sub-menu">
                <li><a class="link_name" href="book_category.php">Books</a></li>
                <li><a href="book_category.php">Borrow Notification</a></li>
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
            <span class="text">DASHBOARD</span>
        </div>
        <div class="content">
            <div class="flexbox">
                <div class="card-1">
                    <?php
                        require('dbconnection.php');

                        $booktotalSql = "SELECT SUM(total_copies) AS total_copies FROM book_tbl";
                        $resultBookTotal = $connect->query($booktotalSql);

                        $totalBooks = 0;
                        if ($resultBookTotal && $resultBookTotal->num_rows > 0) {
                            $row = $resultBookTotal->fetch_assoc();
                            $totalBooks = $row['total_copies'] ?? 0;
                        }
                    ?>
                    <span>Books Total</span>
                    <div>
                        <img src="image/book.png" alt="TOTAL BOOKS" width=70>
                        <span>New and Existing Books</span>
                        <h3><?php echo htmlspecialchars($totalBooks, ENT_QUOTES, 'UTF-8'); ?></h3>
                    </div>
                </div>


                <div class="card-2">
                    <?php
                        $borrowedBooksSql = "SELECT SUM(borrow_quantity) AS total_borrowed FROM borrow_tbl WHERE status = 'Borrowed'";
                        $resultborrowTotal = $connect->query($borrowedBooksSql);
                    
                        $borrowTotal = 0;
                        if ($resultborrowTotal && $resultborrowTotal->num_rows > 0) {
                            $row = $resultborrowTotal->fetch_assoc();
                            $borrowTotal = $row['total_borrowed'] ?? 0;
                        }
                    ?>
                    <span>Books Borrowed</span>
                    <div>
                        <img src="image/book.png" alt="TOTAL BOOKS" width=70>
                        <span>Old & New Books</span>
                        <h3><?php echo htmlspecialchars($borrowTotal, ENT_QUOTES, 'UTF-8'); ?></h3>

                    </div>
                </div>
                <!-- <div class="card-3">
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
                </div> -->
                <div class="report-period">
            
                    <!-- <div class="bookBorrow">
                        <canvas id="book-borrow"></canvas>
                    </div> -->
                </div>
            </div>
            <div class="chart-content">
                <div class="chart-book">
                    <div class="bookCategories">
                        <canvas id="book-category"></canvas>
                    </div>
                    <div class="bookTitle">
                        <canvas id="book-title"></canvas>
                    </div>
                </div>
                <div class="card-borrow">
                    <div class="bookBorrow">
                        <canvas id="book-borrow"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="js/dashboard.js"></script>
    <script>
        fetch('getbook-data.php')
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('book-category').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.categories,
                        datasets: [{
                            label: 'Number of Books Categories',
                            data: data.totals,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true
                            },
                            tooltip: {
                                enabled: true
                            }
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Book Categories',
                                    font: {
                                        weight: 'bold',
                                        size: 15
                                    }
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Number of Books'
                                },
                                beginAtZero: true
                            }
                        }
                    }
                });
            })
        .catch(error => console.error('Error fetching data:', error));
        
        const ctx = document.getElementById('book-title').getContext('2d');
        const bookTitles = <?php echo $bookTitlesJson; ?>;
        const totalCopies = <?php echo $totalCopiesJson; ?>;

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: bookTitles,
                datasets: [{
                    label: 'Total Copies of Each Book',
                    data: totalCopies,
                    borderColor: '#8c8',
                    backgroundColor: '#8c8',
                    borderWidth: 2,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Book Titles',
                            font: {
                                weight: 'bold',
                                size: 15
                            }
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Total Copies'
                        },
                        beginAtZero: true
                    }
                }
            }
        });

        fetch('getborrow-data.php')
        .then(response => response.json())
        .then(data => {
            const labels = data.map(item => item.book_title);
            const borrowTotals = data.map(item => item.total_borrowed);

            function getRandomColor() {
                const letters = '0123456789ABCDEF';
                let color = '#';
                for (let i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
            }

            const randomColors = labels.map(() => getRandomColor());

            const ctx = document.getElementById('book-borrow').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Borrowed Books',
                        data: borrowTotals,
                        backgroundColor: randomColors,
                        borderColor: randomColors, 
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                font: {
                                    size: 14
                                }
                            }
                        },
                        title: {
                            display: true,
                            text: 'Most Borrowed Books',
                            position: 'bottom', 
                            font: {
                                family: 'Verdana', 
                                size: 20, 
                                weight: 'bold', 
                                style: 'italic',
                                lineHeight: 1.2
                            },
                            color: '#333',
                            padding: {
                                top: 20,
                                bottom: 10
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching book borrow data:', error));
    </script>
</body>
</html>