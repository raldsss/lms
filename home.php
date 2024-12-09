
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <link rel="stylesheet" href="css/home.css">
  <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php
        include ('getstudentname.php');
    ?>
    <nav>
    <a href="home.php"  class="nav-link" style="position:relative;left:-5rem; padding:5px; font-size:20px;"><i class="fa fa-user-circle" id="name"></i><span style="position:relative; top:-2px; font-size: 13px; padding:10px;" id="name"><?= $student_name ?></span></a>
        <a href="home.php" class="nav-link active"><i class="fas fa-home"></i></a>
        <a href="student_books.php" class="nav-link"><i class="fas fa-book"></i></a>
        <a href="history.php" class="nav-link"><i class="fas fa-history"></i></a>
        <a href="userinfo.php" class="nav-link"><i class="fas fa-user"></i></a>
        <a href="#" id="logout-link" class="nav-link"><i class="fas fa-sign-out-alt"></i></a>
    </nav>

    <main>
        <div class="home-content">
            <h2>Welcome to our Library Management System </h2>
            <p>LMS is a software solution designed to help libraries manage their operations and resources efficiently</p>
            <a href="student_books.php" class="home-button" style="text-decoration:none;"><i id="arrow" class="fas fa-external-link-alt"></i>Explore Books</a>
        </div>

        <div class="background">
            <img class="img" src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f" alt="">
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

