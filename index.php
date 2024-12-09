<?php
session_start();
require('dbconnection.php');

$errors = [];

if (isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit();
}

if (isset($_SESSION['student_id'])) {
    header('Location: index.php');
    exit();
}

if (isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $student_uid = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $student_password = $_POST['password'] ?? '';

    $admin_login = mysqli_query($connect, "SELECT * FROM admin_tbl WHERE username='$username' AND password='$password'");
    $admin_row = mysqli_fetch_assoc($admin_login);

    if (!empty($admin_row)) { 
        $_SESSION['admin_id'] = $admin_row['admin_id'];
        $_SESSION['admin_name'] = $admin_row['admin_name'];
        $_SESSION['username'] = $admin_row['username'];
        echo "<script>alert('Welcome Admin " . ucwords($admin_row['admin_name']) . "'); window.location='dashboard.php';</script>";
        exit();
    } 

    $student_login = mysqli_query($connect, "SELECT * FROM student_tbl WHERE student_uid='$student_uid' AND student_password='$student_password'");
    $student_row = mysqli_fetch_assoc($student_login);

    if (!empty($student_row)) { 
        $_SESSION['student_id'] = $student_row['student_id'];
        $_SESSION['student_name'] = $student_row['student_name'];
        $_SESSION['student_uid'] = $student_row['student_uid'];
        $_SESSION['student_year'] = $student_row['student_year'];
        $_SESSION['student_section'] = $student_row['student_section'];
        $_SESSION['student_course'] = $student_row['student_course'];
        echo "<script>alert('Welcome " . ucwords($student_row['student_name']) . "'); window.location='home.php';</script>";
        exit();
    } else {
        $errors['login'] = "Incorrect username or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div class="login-container">
        <h2>Welcome to Library Management System</h2>
        <div class="login-card">
            <h3 class="text-center mb-4">Library Login</h3>
            <form action="#" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Enter your Username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                </div>
                <div class="d-grid">
                    <button type="submit" name="login" class="btn btn-login">Login</button>
                </div>
            </form>
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger text-center mt-3">
                    <?php foreach ($errors as $error): ?>
                        <?= htmlspecialchars($error) ?><br>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
