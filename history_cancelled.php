<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CANCELLED</title>
    <link rel="stylesheet" href="css/history.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php
        include('getstudentname.php');
    ?>
    <nav>
        <button class="btn btn-primary" onclick="window.location='home.php'"><?= $student_name ?></button>
        <a href="home.php" class="nav-link active"><i class="fas fa-home"></i></a>
        <a href="student_books.php" class="nav-link"><i class="fas fa-book"></i></a>
        <a href="history.php" class="nav-link"><i class="fas fa-history"></i></a>
        <a href="userinfo.php" class="nav-link"><i class="fas fa-user"></i></a>
        <a href="#" id="logout-link" class="nav-link"><i class="fas fa-sign-out-alt"></i></a>
    </nav>

    <main>
        <h1>History</h1>
        <div class="categories">
            <button onclick="window.location='history.php'" class="category">Pending</button>
            <button onclick="window.location='history_borrowed.php'" class="category">Borrowed</button>
            <button onclick="window.location='history_cancelled.php'" class="category active">Cancelled</button>
        </div>

        <div style="overflow-x:auto;">
            <table>
                <tr>
                    <th>No.</th>
                    <th>Book Name</th>
                    <th>Total Copies</th>
                    <th>Borrow Date</th>
                    <th>Return Date</th>
                    <th>Status</th>
                
                </tr>
                <?php
                    require('dbconnection.php');
                    $sql = "SELECT * FROM borrow_tbl WHERE student_id = '$student_id' AND status = 'Cancelled' ORDER BY borrow_id DESC";
                    $result = $connect->query($sql);
                    if ($result->num_rows > 0) {
                        $counter = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td class='td'>" . $counter . "</td>";
                            echo "<td>" . htmlspecialchars($row["book_title"], ENT_QUOTES, 'UTF-8') . "</td>";
                            echo "<td class='td'>" . htmlspecialchars($row["borrow_quantity"], ENT_QUOTES, 'UTF-8') . "</td>";
                            echo "<td class='td'>" . htmlspecialchars($row["date_borrow"], ENT_QUOTES, 'UTF-8') . "</td>";
                            echo "<td class='td'>" . htmlspecialchars($row["date_return"], ENT_QUOTES, 'UTF-8') . "</td>";
                            echo "<td class='td'><span class='btn btn-danger'>" . htmlspecialchars($row["status"], ENT_QUOTES, 'UTF-8') . "</td>";
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
                            //         </td>";
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
    </main>
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
    </script>
</body>
</html>

