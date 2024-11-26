<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit();
}


// Add dashboard content here
// echo "<h1>Welcome, " . htmlspecialchars($_SESSION['admin_name']) . "!</h1>";
// echo '<a href="logout.php">Logout</a>';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<style>
     /* General Reset */
     * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      font-family: 'Poppins', sans-serif;
      display: flex;
      background-color: #f5f6fa;
    }
    .dashboard {
      display: flex;
      width: 100%;
      height: 100vh;
    }

    /* Sidebar */
    .sidebar {
      background-color: #333;
      color: white;
      width: 250px;
      display: flex;
      flex-direction: column;
    }
    .sidebar-header {
  display: flex;
  align-items: center;
  padding: 20px;
  border-bottom: 1px solid #444;
}

.sidebar-header img {
  width: 50px; /* Adjust logo size */
  height: auto;
  border-radius: 45%;
  margin-right: 10px;
}

.sidebar-header h4 {
  font-size: 1.5rem;
  margin: 0;
}

    .sidebar-menu {
      list-style: none;
      padding: 0;
    }
    .sidebar-menu li {
      padding: 15px 20px;
      font-size: 1rem;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    .sidebar-menu li:hover {
      background-color: #444;
    }
    .sidebar-menu li i {
      margin-right: 10px;
    }

    /* Main Content */
    .main-content {
      flex-grow: 1;
      padding: 20px;
    }
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }
    header h1 {
      font-weight: 600;
    }
    .profile-menu {
      display: flex;
      align-items: center;
    }
    .profile-menu img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      margin-right: 10px;
    }

    /* Overview Cards */
    .overview {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
      margin-bottom: 20px;
    }
    .card {
      background-color: white;
      border-radius: 8px;
      padding: 20px;
      text-align: center;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s, box-shadow 0.3s;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
    }
    .card h3 {
      font-size: 1.2rem;
      margin-bottom: 10px;
    }
    .card p {
      font-size: 1.5rem;
      font-weight: 500;
      color: #333;
    }

    /* Table Section */
    .table {
      background-color: white;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .table h2 {
      margin-bottom: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      text-align: left;
    }
    table th, table td {
      padding: 10px;
      border-bottom: 1px solid #ddd;
    }
    table th {
      background-color: #f5f6fa;
      font-weight: 600;
    }
    .pagination {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }
    .pagination button {
      background-color: #333;
      color: white;
      border: none;
      padding: 10px 20px;
      margin: 0 5px;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    .pagination button:hover {
      background-color: #444;
    }
    .pagination button:disabled {
      background-color: #aaa;
      cursor: not-allowed;
    }
</style>
<body>
<div class="dashboard">
    <!-- Sidebar -->
    <div class="sidebar">
      <div class="sidebar-header">
      <img src="https://www.pngitem.com/pimgs/m/665-6657133_library-management-system-logo-png-transparent-png.png" alt="LMS Logo">
      <h4>LMS</h4>
      </div>
      <ul class="sidebar-menu">
        <li><i class="fa-solid fa-home"></i> Dashboard</li>
        <li><i class="fa-solid fa-book-open"></i><a href="books.php" style="text-decoration:none;color:white;">Books</a></li>
        <li><i class="fa-solid fa-user"></i> Members</li>
        <li><i class="fa-solid fa-list"></i> Borrowed Books</li>
        <li><i class="fa-solid fa-gear"></i> Settings</li>
        <li><i class="fa-solid fa-right-from-bracket"></i><a href="logout.php" style="text-decoration:none;color:white;">Logout</a></li>
      </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
      <header>
        <h1>Dashboard</h1>
        <div class="profile-menu">
          <img src="https://cdn4.iconfinder.com/data/icons/avatars-xmas-giveaway/128/batman_hero_avatar_comics-512.png" alt="User Profile">
          <span>Admin</span>
        </div>
      </header>

      <section class="overview">
        <div class="card">
          <h3><i class="fa-solid fa-book"></i> Total Books</h3>
          <p>5,678</p>
        </div>
        <div class="card">
          <h3><i class="fa-solid fa-user"></i> Total Members</h3>
          <p>1,234</p>
        </div>
        <div class="card">
          <h3><i class="fa-solid fa-bookmark"></i> Borrowed Books</h3>
          <p>345</p>
        </div>
        <div class="card">
          <h3><i class="fa-solid fa-calendar"></i> Overdue Books</h3>
          <p>12</p>
        </div>
      </section>

      <section class="table">
        <h2>Recent Borrowed Books</h2>
        <table id="data-table">
          <thead>
            <tr>
              <th>Book Title</th>
              <th>Member Name</th>
              <th>Borrowed Date</th>
              <th>Due Date</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody id="table-body">
      
          </tbody>
        </table>
       
      </section>
    </div>
  </div>

 
</body>
</html>