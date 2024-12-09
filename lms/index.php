<?php
session_start();
require ('dbconnection.php');

$errors = [];

if(isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit();
}

// if(isset($_SESSION['student_id'])) {
//     header('Location: index.php');
//     exit();
// }

if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $admin_login = mysqli_query($connect, "SELECT * FROM admin_tbl WHERE username='$username' AND password='$password'");
    $admin_row = mysqli_fetch_assoc($admin_login);

    if(!empty($admin_row)){ 
        $_SESSION['admin_id'] = $admin_row['admin_id'];
        $_SESSION['admin_name'] = $admin_row['admin_name'];
        $_SESSION['username'] = $admin_row['username'];
        $_SESSION['password'] = $admin_row['password'];
        echo "<script>alert('Welcome Admin ".ucwords($admin_row['admin_name'])."'); window.location='dashboard.php';</script>";
        exit();
    // } 

    // $student_login = mysqli_query($connect, "SELECT * FROM student_tbl WHERE username='$username' AND password='$password'");
    // $staff_row = mysqli_fetch_assoc($student_login);

    // if(!empty($staff_row)){ 
    //     $_SESSION['student_id'] = $staff_row['student_id'];
    //     $_SESSION['full_name'] = $staff_row['full_name'];
    //     $_SESSION['mobile_number'] = $staff_row['mobile_number'];
    //     $_SESSION['gender'] = $staff_row['gender'];
    //     $_SESSION['email'] = $staff_row['email'];
    //     $_SESSION['username'] = $staff_row['username'];
    //     $_SESSION['password'] = $staff_row['password'];
    //     echo "<script>alert('Welcome ".ucwords($staff_row['full_name'])."'); window.location='student_panel.php';</script>";
    //     exit();
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
    <link rel="stylesheet" href="css/index.css">
    <title>Library Management System</title>
</head>
<body>
    <section>
        <div class="container">
            <div class="library-text">
                <span>Library Management System</span>
            </div>
            <div class="image">
                <img src="image/library-logo.png" alt="Library-logo">
            </div>
            <div class="form">
                <form action="#" method="POST">
                    <div class="form-content">
                        <div class="welcome">
                            <span>Welcome to Library Management System</span>
                        </div>
                        <div class="input">
                            <div>
                                <span>Username :</span>
                                <input type="text" name="username" required>
                            </div>
                            <div class="password">
                                <span>Password :</span>
                                <input type="password" name="password" required>
                            </div>
                            <div class="submit">
                                <input type="submit" name="login" value="Login">
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                    if(!empty($errors)) {
                        ?>
                        <div class="alert alert-danger text-center">
                            <?php
                            foreach($errors as $error){
                                echo $error . "<br>";
                            }
                            ?>
                        </div>
                        <?php
                    }
                ?>
            </div>
        </div>
    </section>
</body>
</html>