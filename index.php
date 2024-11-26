<?php
session_start();
require('dbconnection.php');

$errors = [];

// Check if already logged in
if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit();
}

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Use prepared statements to prevent SQL injection
    $stmt = $connect->prepare("SELECT * FROM admin_tbl WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin_row = $result->fetch_assoc();

    if (!empty($admin_row)) {
        // Set session variables
        $_SESSION['admin_id'] = $admin_row['admin_id'];
        $_SESSION['admin_name'] = $admin_row['admin_name'];
        $_SESSION['username'] = $admin_row['username'];
        echo "<script>alert('Welcome Admin " . ucwords($admin_row['admin_name']) . "'); window.location='dashboard.php';</script>";
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
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background: url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f') no-repeat center center/cover;
            font-family: 'Poppins', sans-serif;
        }
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #6c63ff;
        }
        .btn-login {
            background-color: #6c63ff;
            color: white;
            border: none;
        }
        .btn-login:hover {
            background-color: #5750d6;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h3 class="text-center mb-4"><i class="fas fa-book"></i> Library Login</h3>
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
