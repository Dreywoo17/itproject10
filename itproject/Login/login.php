<?php
// Start session to use session variables
session_start();

// Include the database connection
require('C:/xampp/htdocs/itproject/DBconnect/Conn_accounts.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $user_type = $_POST['user_type'];

    $email = htmlspecialchars($email);
    $password = htmlspecialchars($password);

    // Validate inputs
    if (empty($email) || empty($password) || empty($user_type)) {
        exit("<div class='alert alert-danger text-center'>All fields are required.</div>");
    }

    if (!preg_match('/@g\.cu\.edu\.ph$/', $email)) {
        exit("<div class='alert alert-danger text-center'>Please use your CU corporate email.</div>");
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        exit("<div class='alert alert-danger text-center'>Invalid email format.</div>");
    }

    // Check user credentials based on user type
    if ($user_type == "Student") {
        $sql = "SELECT * FROM students WHERE student_email = ?";
    } elseif ($user_type == "Teacher") {
        $sql = "SELECT * FROM teacher WHERE teacher_email = ?"; 
    } elseif ($user_type == "Admin") {
        $sql = "SELECT * FROM admin WHERE admin_email = ?";
    } else {
        die("<div class='alert alert-danger text-center'>Invalid user type.</div>");
    }

    // Prepare SQL statement
    $statement = $conn->prepare($sql);
    $statement->bind_param("s", $email);

    // Execute query
    $statement->execute();
    $result = $statement->get_result();

    // Check if user exists and verify password
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['user_password'])) {
            // Successful login
            $_SESSION['user_id'] = $user['id']; // Store user session
            $_SESSION['user_type'] = $user_type;

            // Redirect to the appropriate dashboard
            if ($user_type == "Admin") {
                header("Location: /itproject/Admin/viewadmin.php"); // Admin Dashboard
            } elseif ($user_type == "Teacher") {
                header("Location: /itproject/Login/teacher/teacher.php"); // Teacher Dashboard
            } else {
                header("Location: /itproject/Login/Students/addappoint.php"); // Student Dashboard
            }
            exit();
        } else {
            echo "<div class='alert alert-danger text-center'>Incorrect password.</div>";
        }
    } else {
        echo "<div class='alert alert-danger text-center'>No account found with that email.</div>";
    }

    // Close the statement and connection
    $statement->close();
    $conn->close();
}
?>

<!-- Login Form HTML -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Appointment Scheduling System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/itproject/Login/Asset/addappoint.css">
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
        <div class="container-fluid">
            <!-- Logo and Brand Name -->
            <a class="navbar-brand" href="#">
                <img src="../img/Alogo1.jpg" alt="Logo" width="50" height="50" class="d-inline-block align-text-center">Appointment Scheduling System
            </a>
            <!-- Mobile Menu Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Navigation Menu Items -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link text-white" href="/itproject/aboutus.php">About Us</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="/itproject/Login/login.php"><i class="fa-regular fa-user"></i> Log in</a></li>
                </ul>
                
            </div>
        </div>
    </nav>
    
    <!-- Login Form Container -->
    <div class="container d-flex justify-content-center align-items-center" style="height: 80vh;">
        <div class="card p-4 shadow" style="width: 320px;">
            <h1 class="text-center">Login</h1>
            
            <form action="login.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">User Type</label>
                    <select name="user_type" class="form-control" required>
                        <option value="Student">Student</option>
                        <option value="Teacher">Teacher</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>

                <div class="mb-3">
                    <input type="email" class="form-control" name="email" placeholder="Enter your CU email" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Login</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
