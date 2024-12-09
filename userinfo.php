<?php
require('dbconnection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_uid = $_POST['student_uid'];
    $student_name = $_POST['student_name'];
    $student_course = $_POST['student_course'];
    $student_year = $_POST['student_year'];
    $student_section = $_POST['student_section'];
    $student_password = $_POST['student_password'];
    $student_id = $_POST['student_id'];

    $stmt = $connect->prepare("
        UPDATE student_tbl
        SET  student_uid = ?, student_name = ?, student_course = ?, student_year = ?, student_section = ?, student_password = ?
        WHERE student_id = ?
    ");
    $stmt->bind_param("ssssssi", $student_uid, $student_name, $student_course, $student_year,  $student_section, $student_password, $student_id);

    if ($stmt->execute()) {
        echo "<script>
                alert('Profile updated successfully!');
                window.location.href = 'userinfo.php';
              </script>";
    } else {
        echo "<script>
                alert('Failed to update profile. Please try again.');
                window.location.href = 'userinfo.php';
              </script>";
    }

    $stmt->close();
    $connect->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/userinfo.css">
</head>
<body>
    <?php
        include('getstudentname.php');
    ?>
    <nav>
    <a href="home.php"  class="nav-link" style="position:relative;left:-5rem; padding:5px; font-size:20px;"><i class="fa fa-user-circle" id="name"></i><span style="position:relative; top:-2px; font-size: 13px; padding:10px;" id="name"><?= $student_name ?></span></a>
        <a href="home.php" class="nav-link active"><i class="fas fa-home"></i></a>
        <a href="student_books.php" class="nav-link"><i class="fas fa-book"></i></a>
        <a href="history.php" class="nav-link"><i class="fas fa-history"></i></a>
        <a href="userinfo.php" class="nav-link"><i class="fas fa-user"></i></a>
        <a href="#" id="logout-link" class="nav-link"><i class="fas fa-sign-out-alt"></i></a>
    </nav>

   <!-- Main Content -->
  <main>
    <h1 class="title">Personal Information</h1>
    <div class="user-card">
      <img class="img" id="user-avatar" src="https://www.pngitem.com/pimgs/m/150-1503945_transparent-user-png-default-user-image-png-png.png" alt="User Avatar">
      <h2><?php echo htmlspecialchars($student_name); ?></h2>
      <p>Id : <?php echo htmlspecialchars($student_uid); ?></p>
      <div class="info">
        <div>
          <p><?php echo htmlspecialchars($student_course); ?></p>
        </div>
        <div>
          <p><?php echo htmlspecialchars($student_year); ?></p>
        </div>
        <div>
          <p><?php echo htmlspecialchars($student_section); ?></p>
        </div>
      </div>
      <div class="button_view">
      <button class="edit btn " data-bs-toggle="modal" data-bs-target="#editModal" 
        onclick="populateModal('<?php echo $student_id; ?>', '<?php echo htmlspecialchars($student_name); ?>', '<?php echo htmlspecialchars($student_course); ?>', '<?php echo htmlspecialchars($student_year); ?>', '<?php echo htmlspecialchars($student_section); ?>', '<?php echo htmlspecialchars($student_uid); ?>')">Update Information</button>
      </div>
    </div>
  </main>

  <!-- Modal for Editing Information -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="POST" action="userinfo.php">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit Information</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
          <input type="hidden" id="edit_student_id" name="student_id">
            <div class="mb-3">
              <label for="student_name" class="form-label">Name</label>
              <input type="text" class="form-control" id="student_name" name="student_name" value="<?php echo htmlspecialchars($student_name); ?>" required>
            </div>
            <div class="mb-3">
              <label for="student_course" class="form-label">Course</label>
              <input type="text" class="form-control" id="student_course" name="student_course" value="<?php echo htmlspecialchars($student_course); ?>" required>
            </div>
            <div class="mb-3">
              <label for="student_year" class="form-label">Year</label>
              <input type="text" class="form-control" id="student_year" name="student_year" value="<?php echo htmlspecialchars($student_year); ?>" required>
            </div>
            <div class="mb-3">
              <label for="student_section" class="form-label">Section</label>
              <input type="text" class="form-control" id="student_section" name="student_section" value="<?php echo htmlspecialchars($student_section); ?>" required>
            </div>
            <div class="mb-3">
              <label for="student_uid" class="form-label">Student ID</label>
              <input type="text" class="form-control" id="student_uid" name="student_uid" value="<?php echo htmlspecialchars($student_uid); ?>" required>
            </div>
            <div class="mb-3">
              <label for="student_password" class="form-label">Password</label>
              <input type="password" class="form-control" id="student_password" name="student_password" value="<?php echo htmlspecialchars($student_password); ?>" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  

  <!-- Logout Confirmation Script -->
  <script>
    function populateModal(student_id, student_name, student_course, student_year, student_section, student_uid, student_password) {
    // Set the values of the modal inputs
    document.getElementById('edit_student_id').value = student_id;
    document.getElementById('student_name').value = student_name;
    document.getElementById('student_course').value = student_course;
    document.getElementById('student_year').value = student_year;
    document.getElementById('student_section').value = student_section;
    document.getElementById('student_uid').value = student_uid;
    document.getElementById('student_password').value = student_password;

  }

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
  <!-- <script scr="js/userinfo.js"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>