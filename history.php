<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f9f9f9;
        }
        h1 {
            font-size: 1.5rem;
            margin: 1rem;
        }
        nav {
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 0.75rem 1rem;
            background-color: #007bff;
            color: white;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        nav a {
            color: white;
            font-size: 1.2rem;
            text-decoration: none;
        }
        nav a.active {
            font-weight: bold;
        }
        .categories {
            display: flex;
            gap: 0.5rem;
            overflow-x: auto;
            padding: 1rem;
        }
        .category {
            padding: 0.5rem 1rem;
            background-color: #f0f0f0;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.7rem;
            border: none;
        }
        .category.active {
            background-color: #007bff;
            color: white;
        }
        .table-container {
            display: none;
        }
        .table-container.active {
            display: block;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            font-size: 0.8rem;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <?php include('getstudentname.php'); ?>
    <nav>
        <a href="home.php" class="nav-link active"><i class="fas fa-home"></i></a>
        <a href="student_books.php" class="nav-link"><i class="fas fa-book"></i></a>
        <a href="#" class="nav-link"><i class="fas fa-history"></i></a>
        <a href="userinfo.php" class="nav-link"><i class="fas fa-user"></i></a>
        <a href="#" id="logout-link" class="nav-link"><i class="fas fa-sign-out-alt"></i></a>
    </nav>

    <main>
        <h1>History</h1>
        <div class="categories">
            <button class="category active" data-target="pending-table">Pending</button>
            <button class="category" data-target="transaction-table">Transaction History</button>
            <button class="category" data-target="cancelled-table">Cancelled</button>
        </div>

        <div style="overflow-x:auto;">
            <!-- Table Containers -->
            <?php
require('dbconnection.php');
$statuses = ['Pending', 'Approved', 'Cancelled'];
foreach ($statuses as $status) {
    $sql = "SELECT * FROM borrow_tbl WHERE student_id = ? AND status = ? ORDER BY borrow_id DESC";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param('ss', $student_id, $status);
    $stmt->execute();
    $result = $stmt->get_result();
    $tableId = strtolower($status) . "-table";
?>
<div id="<?php echo $tableId; ?>" class="table-container <?php echo $status === 'Pending' ? 'active' : ''; ?>">
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
        if ($result->num_rows > 0) {
            $counter = 1;
            while ($row = $result->fetch_assoc()) {
                $statusColor = '';
                if ($row["status"] === 'Pending') {
                    $statusColor = 'style="color: #ffc107; font-weight: bold;"';
                } elseif ($row["status"] === 'Cancelled') {
                    $statusColor = 'style="color: #dc3545; font-weight: bold;"';
                } elseif ($row["status"] === 'Approved') {
                    $statusColor = 'style="color: #28a745; font-weight: bold;"';
                }

                echo "<tr>
                    <td>{$counter}</td>
                    <td>" . htmlspecialchars($row["book_title"], ENT_QUOTES, 'UTF-8') . "</td>
                    <td>" . htmlspecialchars($row["borrow_quantity"], ENT_QUOTES, 'UTF-8') . "</td>
                    <td>" . htmlspecialchars($row["date_borrow"], ENT_QUOTES, 'UTF-8') . "</td>
                    <td>" . htmlspecialchars($row["date_return"], ENT_QUOTES, 'UTF-8') . "</td>
                    <td {$statusColor}>" . htmlspecialchars($row["status"], ENT_QUOTES, 'UTF-8') . "</td>
                </tr>";
                $counter++;
            }
        } else {
            echo "<tr><td colspan='6'>No records found</td></tr>";
        }
        ?>
    </table>
</div>
<?php } ?>

        </div>
    </main>

    <script>
        // Category buttons toggle logic
        document.querySelector('.categories').addEventListener('click', function (e) {
            if (e.target.classList.contains('category')) {
                document.querySelectorAll('.category').forEach(btn => btn.classList.remove('active'));
                document.querySelectorAll('.table-container').forEach(table => table.classList.remove('active'));
                
                e.target.classList.add('active');
                document.getElementById(e.target.dataset.target).classList.add('active');
            }
        });

        // Logout confirmation
        document.getElementById('logout-link').addEventListener('click', function (event) {
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
