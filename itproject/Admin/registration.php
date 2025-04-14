<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'C:/xampp/htdocs/itproject/DBconnect/Conn_accounts.php';

$feedback = '';
$targetDir = "uploads/";
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0755, true);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $user_type = $_POST['user_type'] ?? '';

    $imagePath = '';
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $imageName = $_FILES['profile_image']['name'];
        $imageType = $_FILES['profile_image']['type'];
        $tmpName = $_FILES['profile_image']['tmp_name'];
        $imagePath = $targetDir . basename($imageName);

        // Move the uploaded file to the target directory
        move_uploaded_file($tmpName, $imagePath);

        // Insert image details into uploaded_images table
        $imgSQL = "INSERT INTO uploaded_images (image_name, image_type, image_data) VALUES (?, ?, ?)";
        $imgStmt = $conn->prepare($imgSQL);
        $imgStmt->bind_param("sss", $imageName, $imageType, $imagePath);
        $imgStmt->execute();
        $imgStmt->close();
    }

    // Validation checks
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password) || empty($user_type)) {
        $feedback = "<div class='alert alert-danger text-center'>All fields are required.</div>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $feedback = "<div class='alert alert-danger text-center'>Invalid email format.</div>";
    } elseif ($password !== $confirm_password) {
        $feedback = "<div class='alert alert-danger text-center'>Passwords do not match.</div>";
    } elseif (!preg_match('/@g\.cu\.edu\.ph$/', $email)) {
        $feedback = "<div class='alert alert-danger text-center'>Please use your CU corporate email.</div>";
    } else {
        // Check if the email already exists in any user table
        $check_sql = "
            SELECT email FROM (
                SELECT student_email AS email FROM students
                UNION
                SELECT teacher_email AS email FROM teacher
                UNION
                SELECT admin_email AS email FROM admin
            ) AS all_users
            WHERE email = ?
        ";
        $check_statement = $conn->prepare($check_sql);
        $check_statement->bind_param("s", $email);
        $check_statement->execute();
        $check_statement->store_result();

        if ($check_statement->num_rows > 0) {
            $feedback = "<div class='alert alert-danger text-center'>Email is already registered.</div>";
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            if ($user_type == "Student") {
                $sql = "INSERT INTO students (student_name, student_email, user_password, profile_image) VALUES (?, ?, ?, ?)";
            } elseif ($user_type == "Teacher") {
                $sql = "INSERT INTO teacher (teacher_name, teacher_email, user_password, profile_image) VALUES (?, ?, ?, ?)";
            } elseif ($user_type == "Admin") {
                $sql = "INSERT INTO admin (admin_name, admin_email, user_password, profile_image) VALUES (?, ?, ?, ?)";
            }

            if (isset($sql)) {
                $statement = $conn->prepare($sql);
                $statement->bind_param("ssss", $name, $email, $hashed_password, $imagePath);
                if ($statement->execute()) {
                    $feedback = "<div class='alert alert-success text-center'>Registration successful!
                    <script>setTimeout(function(){ window.location.href = 'viewadmin.php'; }, 2000);</script></div>";
                } else {
                    $feedback = "<div class='alert alert-danger text-center'>Error: " . $statement->error . "</div>";
                }
                $statement->close();
            }
        }
        $check_statement->close();
    }
    $conn->close();
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="/itproject/Admin/Asset/registration.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
        <a class="navbar-brand" href="#">
            <img src="../img/Alogo1.jpg" alt="Logo"> Appointment Scheduling
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link text-white" href="/itproject/aboutus.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="/itproject/Login/login.php"><i class="fa-regular fa-user"></i> Log in</a></li>
            </ul>
        </div>
    </nav>

    <div class="container"><br><br>
        <div class="card p-4">
            <?php echo $feedback; ?>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
                <div class="header">
                    <h2 class="text-dark">Appointment Scheduling System</h2>
                    <p>Register for an account</p>
                </div>
                <div class="mb-3">
                    <div class="mb-3">
                    <label class="form-label">Upload Profile Image</label>
                    <input type="file" class="form-control" name="profile_image" accept="image/*">
                    </div>
                    <label class="form-label">User Type</label> 
                    <div>
                        <input type="radio" id="student" name="user_type" value="Student" required>
                        <label for="student">Student</label>
                        <input type="radio" id="teacher" name="user_type" value="Teacher" required>
                        <label for="teacher">Teacher</label>
                        <input type="radio" id="admin" name="user_type" value="Admin" required>
                        <label for="admin">Admin</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">CU Corporate Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" name="confirm_password" required>
                </div>
                <button type="submit" class="btn btn-custom w-100 text-white">Register</button>
            </form>
        </div>
    </div>
</body>
</html>
